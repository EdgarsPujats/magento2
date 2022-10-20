<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Model\QuestionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magebit\Faq\Api\Data\QuestionInterface;

/**
 * Edit FAQ question action.
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magebit_Faq::save';

    /**
     * Core registry
     *
     * @var Registry
     */
    protected Registry $_coreRegistry;

    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @var QuestionFactory
     */
    private QuestionFactory $questionFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $registry
     * @param QuestionFactory $questionFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory    $resultPageFactory,
        Registry       $registry,
        QuestionFactory $questionFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return Page
     */
    protected function _initAction(): Page
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magebit_faq::faq_question')
            ->addBreadcrumb(__('FAQ'), __('FAQ'))
            ->addBreadcrumb(__('Manage Questions'), __('Manage Questions'));
        $resultPage->getConfig()->getTitle()->prepend((__('Frequently Asked Questions')));

        return $resultPage;
    }

    /**
     * Edit FAQ question
     *
     * @return Page|Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(QuestionInterface::QUESTION_ID);
        $model = $this->questionFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This question no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register(QuestionInterface::MAIN_TABLE, $model);

        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Question') : __('New Question'),
            $id ? __('Edit Question') : __('New Question')
        );

        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? __('FAQ Question') : __('New Question'));

        return $resultPage;
    }
}
