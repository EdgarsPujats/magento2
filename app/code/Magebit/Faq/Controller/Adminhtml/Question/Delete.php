<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Exception;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magebit\Faq\Model\QuestionRepositoryFactory;

/**
 * Delete FAQ question action.
 */
class Delete extends Action implements HttpPostActionInterface
{

    /**
     * @var QuestionRepositoryFactory
     */
    private QuestionRepositoryFactory $questionRepositoryFactory;

    /**
     * @param Context $context
     * @param QuestionRepositoryFactory $questionRepositoryFactory
     */
    public function __construct(Context $context, QuestionRepositoryFactory $questionRepositoryFactory)
    {
        $this->questionRepositoryFactory = $questionRepositoryFactory;
        parent::__construct($context);
    }

    /**
     * Delete FAQ question action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam(QuestionInterface::QUESTION_ID);
        if ($id) {
            try {
                $model = $this->questionRepositoryFactory->create();
                $model->delete($model->getById($id));

                $this->messageManager->addSuccessMessage(__('You deleted the question.'));

                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', [QuestionInterface::QUESTION_ID => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a question to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}

