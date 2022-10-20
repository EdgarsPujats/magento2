<?php

declare(strict_types=1);

namespace Magebit\Faq\Block\Adminhtml\Question\Edit;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected Context $context;

    /**
     * @var QuestionRepositoryInterface
     */
    protected QuestionRepositoryInterface $questionRepository;

    /**
     * @param Context $context
//     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        Context $context,
        QuestionRepositoryInterface $questionRepository
    ) {
        $this->context = $context;
        $this->questionRepository = $questionRepository;
    }

    /**
     * Return FAQ question ID
     *
     * @return int|null
     * @throws LocalizedException
     */
    public function getQuestionId(): ?int
    {
        try {
            return $this->questionRepository->getById(
                $this->context->getRequest()->getParam(QuestionInterface::QUESTION_ID)
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return  string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
