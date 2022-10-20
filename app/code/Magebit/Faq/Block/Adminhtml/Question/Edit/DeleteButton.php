<?php

declare(strict_types=1);

namespace Magebit\Faq\Block\Adminhtml\Question\Edit;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @inheritDoc
     * @throws LocalizedException
     */
    public function getButtonData(): array
    {
        $data = [];
        if ($this->getQuestionId()) {
            $data = [
                'label' => __('Delete Question'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * URL to send delete requests to.
     *
     * @return string
     * @throws LocalizedException
     */
    public function getDeleteUrl(): string
    {
        return $this->getUrl('*/*/delete', [QuestionInterface::QUESTION_ID => $this->getQuestionId()]);
    }
}
