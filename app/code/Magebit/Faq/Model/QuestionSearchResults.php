<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\QuestionSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Question search results.
 */
class QuestionSearchResults extends SearchResults implements QuestionSearchResultsInterface
{
}
