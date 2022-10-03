<?php

declare(strict_types=1);

namespace Magebit\PageListWidget\Block\Widget;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Helper\Page;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;

/**
 *
 */
class PageList extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = 'widget/page-list.phtml';

    /**
     * @var PageRepositoryInterface
     */
    private PageRepositoryInterface $pageRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    /**
     * @var Page
     */
    private Page $cmsHelperPage;

    /**
     * @param Context $context
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param PageRepositoryInterface $pageRepository
     * @param Page $cmsHelperPage
     * @param array $data
     */

    public function __construct(
        Template\Context        $context,
        SearchCriteriaBuilder   $searchCriteriaBuilder,
        PageRepositoryInterface $pageRepository,
        Page                    $cmsHelperPage,
        array                   $data = []
    ) {
        parent::__construct($context, $data);
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->cmsHelperPage = $cmsHelperPage;
    }

    /**
     * @throws LocalizedException
     */
    public function getCmsPageLinks(): array
    {
        $selectedPages = $this->getData('selected_pages');
        $criteria = $this->searchCriteriaBuilder->addFilter('is_active', 1);

        if ($selectedPages) {
            $criteria->addFilter('page_id', $selectedPages, 'in');
        }

        $criteria = $criteria->create();
        return $this->pageRepository->getList($criteria)->getItems();
    }

    /**
     * @param int $id
     * @return string|null
     */
    public function getCmsPageLinkUrl(int $id): ?string
    {
        return $this->cmsHelperPage->getPageUrl($id);
    }
}
