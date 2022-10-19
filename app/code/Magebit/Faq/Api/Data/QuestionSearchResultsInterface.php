<?php

namespace Magebit\Faq\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for FAQ question search results
 * @api
 * @since 100.1.0
 */
interface QuestionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get question list.
     *
     * @return QuestionInterface[]
     */
    public function getItems();

    /**
     * Set question list.
     *
     * @param QuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
