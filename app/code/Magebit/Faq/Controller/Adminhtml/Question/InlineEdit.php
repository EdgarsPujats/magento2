<?php

declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magebit\Faq\Api\QuestionRepositoryInterface as QuestionRepository;
use Magebit\Faq\Model\Question;
use Magento\Framework\Controller\Result\JsonFactory;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Inline FAQ question edit action.
 */
class InlineEdit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magento_Faq::question';

    /**
     * @var QuestionRepository
     */
    protected QuestionRepository $questionRepository;

    /**
     * @var JsonFactory
     */
    protected JsonFactory $jsonFactory;

    /**
     * @param Context $context
     * @param QuestionRepository $questionRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        QuestionRepository $questionRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute(): ResultInterface
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $questionId) {
                    /** @var Question $question */
                    $question = $this->questionRepository->getById($questionId);
                    try {
                        $question->setData(array_merge($question->getData(), $postItems[$questionId]));
                        $this->questionRepository->save($question);
                    } catch (Exception $e) {
                        $messages[] = $this->getErrorWithQuestionId(
                            $question,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add question title to error message
     *
     * @param QuestionInterface $question
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithQuestionId(QuestionInterface $question, string $errorText): string
    {
        return '[Question ID: ' . $question->getId() . '] ' . $errorText;
    }
}
