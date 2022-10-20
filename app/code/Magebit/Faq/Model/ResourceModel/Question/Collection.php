<?php

declare(strict_types=1);

namespace Magebit\Faq\Model\ResourceModel\Question;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Model\Question;
use Magebit\Faq\Model\ResourceModel\Question as ResourceQuestion;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * FAQ Question Collection.
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = QuestionInterface::QUESTION_ID;

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'faq_question_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'question_collection';

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        return parent::_afterLoad();
    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(Question::class, ResourceQuestion::class);
        $this->_map['fields']['store'] = 'store_table.store_id';
        $this->_map['fields'][QuestionInterface::QUESTION_ID] = 'main_table.id';
    }

    /**
     * Returns pairs id - question
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return $this->_toOptionArray(QuestionInterface::QUESTION_ID, QuestionInterface::QUESTION);
    }

    public function addStoreFilter($store, $withAdmin = true): static
    {
        $this->performAddStoreFilter($store, $withAdmin);

        return $this;
    }
}
