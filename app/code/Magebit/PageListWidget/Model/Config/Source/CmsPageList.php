<?php

declare(strict_types=1);

namespace Magebit\PageListWidget\Model\Config\Source;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Option\ArrayInterface;

/**
 * Shows list of active pages
 */
class CmsPageList implements ArrayInterface
{
    /**
     * @var PageRepositoryInterface
     */
    private PageRepositoryInterface $pageRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        SearchCriteriaBuilder   $searchCriteriaBuilder,
        PageRepositoryInterface $pageRepository
    ) {
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @throws LocalizedException
     */
    public function toOptionArray(): array
    {
        $criteria = $this->searchCriteriaBuilder->addFilter('is_active', 1)->create();
        $pages = $this->pageRepository->getList($criteria)->getItems();
        $results = [];
        foreach ($pages as $page) {
            $results[] = ['value' => $page->getId(), 'label' => $page->getTitle()];
        }

        return $results;
    }
}
