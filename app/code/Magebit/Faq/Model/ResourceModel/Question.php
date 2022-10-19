<?php

namespace Magebit\Faq\Model\ResourceModel;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Question extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(QuestionInterface::MAIN_TABLE, QuestionInterface::QUESTION_ID);
    }
}
