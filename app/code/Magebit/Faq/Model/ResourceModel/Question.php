<?php

declare(strict_types=1);

namespace Magebit\Faq\Model\ResourceModel;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * FAQ question resource model.
 */
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
