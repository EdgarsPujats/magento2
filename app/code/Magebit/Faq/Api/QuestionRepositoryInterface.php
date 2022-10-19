<?php

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\Data\QuestionSearchResultsInterface;
use Magebit\Faq\Model\Question;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * FAQ question CRUD interface.
 * @api
 * @since 100.0.2
 */
interface QuestionRepositoryInterface
{
    /**
     * Save question.
     *
     * @param Question $question
     * @return Question
     * @throws LocalizedException
     */
    public function save(QuestionInterface $question): QuestionInterface;

    /**
     * Retrieve question.
     *
     * @param ?int $questionId
     * @return QuestionInterface
     * @throws LocalizedException
     */
    public function getById(?int $questionId): QuestionInterface;

    /**
     * Retrieve questions matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return QuestionSearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): QuestionSearchResultsInterface;

    /**
     * Delete question.
     *
     * @param QuestionInterface $question
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(QuestionInterface $question): bool;

    /**
     * Delete question by ID.
     *
     * @param int $questionId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $questionId): bool;
}
