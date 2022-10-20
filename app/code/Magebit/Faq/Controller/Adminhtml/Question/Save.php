<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Exception;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Model\Question;
use Magebit\Faq\Model\QuestionFactory;
use Magebit\Faq\Model\QuestionRepositoryFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

/**
 * Save FAQ question action.
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @var QuestionFactory
     */
    private mixed $questionFactory;

    /**
     * @var QuestionRepositoryFactory
     */
    private mixed $questionRepository;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param QuestionFactory $questionFactory
     * @param QuestionRepositoryFactory $questionRepositoryFactory
     */
    public function __construct(
        Context                   $context,
        Registry                  $coreRegistry,
        DataPersistorInterface    $dataPersistor,
        QuestionFactory           $questionFactory,
        QuestionRepositoryFactory $questionRepositoryFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->questionFactory = $questionFactory;
        $this->questionRepository = $questionRepositoryFactory->create();
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            /** @var QuestionInterface $model */
            $model = $this->questionFactory->create();

            $id = $this->getRequest()->getParam(QuestionInterface::QUESTION_ID);
            if ($id) {
                try {
                    $model = $this->questionRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This question no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->questionRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the question.'));
                $this->dataPersistor->clear(QuestionInterface::MAIN_TABLE);
                return $this->processQuestionReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the question.'));
            }

            $this->dataPersistor->set(QuestionInterface::MAIN_TABLE, $data);
            return $resultRedirect->setPath('*/*/edit', [QuestionInterface::QUESTION_ID => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the question return
     *
     * @param Question $model
     * @param array $data
     * @param ResultInterface $resultRedirect
     * @return ResultInterface
     */
    private function processQuestionReturn(Question $model, array $data, ResultInterface $resultRedirect): ResultInterface
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', [QuestionInterface::QUESTION_ID => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect;
    }
}
