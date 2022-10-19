<?php

namespace Magebit\Faq\Block;

use Magebit\Faq\Model\QuestionRepositoryFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * FAQ question list
 */
class QuestionList extends Template
{
    /**
     * @var QuestionRepositoryFactory
     */
    protected QuestionRepositoryFactory $questionRepositoryFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    private SortOrderBuilder $sortOrderBuilder;

    /**
     * @param Context $context
     * @param QuestionRepositoryFactory $questionRepositoryFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        Context               $context,
        QuestionRepositoryFactory       $questionRepositoryFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder      $sortOrderBuilder
    ) {
        $this->questionRepositoryFactory = $questionRepositoryFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        parent::__construct($context);
    }

    /**
     * @return array
     */
    public function getQuestions(): array
    {
        $questionModel = $this->questionRepositoryFactory->create();

        $sortOrder = $this->sortOrderBuilder->setField('position')->setDirection('ASC')->create();
        $criteria = $this->searchCriteriaBuilder->addFilter('status', 1)->setSortOrders([$sortOrder])->create();

        return $questionModel->getList($criteria)->getItems();
    }
}
