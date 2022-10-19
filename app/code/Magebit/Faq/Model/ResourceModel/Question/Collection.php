<?php

namespace Magebit\Faq\Model\ResourceModel\Question;

use Magebit\Faq\Model\Question;
use Magebit\Faq\Model\ResourceModel\Question as ResourceQuestion;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * FAQ Question Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

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
    protected function _construct()
    {
        $this->_init(Question::class, ResourceQuestion::class);
        $this->_map['fields']['store'] = 'store_table.store_id';
        $this->_map['fields']['id'] = 'main_table.id';
    }

    /**
     * Returns pairs id - question
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('id', 'question');
    }

    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->performAddStoreFilter($store, $withAdmin);

        return $this;
    }
}
