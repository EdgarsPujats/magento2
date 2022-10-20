<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Model\ResourceModel\Question as QuestionResourceModel;
use Magento\Framework\Model\AbstractModel;

/**
 * FAQ question model.
 */
class Question extends AbstractModel implements QuestionInterface
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init(QuestionResourceModel::class);
    }

    /**
     * Retrieve question ID
     *
     * @return ?int
     */
    public function getId(): ?int
    {
        if (empty($this->getData(self::QUESTION_ID))) {
            return null;
        }

        return (int) $this->getData(self::QUESTION_ID);
    }

    /**
     * Retrieve question
     *
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->getData(self::QUESTION);
    }

    /**
     * Retrieve question answer
     *
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->getData(self::ANSWER);
    }

    /**
     * Retrieve question status
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Retrieve question position
     *
     * @return int
     */
    public function getPosition(): int
    {
        return $this->getData(self::POSITION);
    }

    /**
     * Set question
     *
     * @param string $question
     * @return QuestionInterface
     */
    public function setQuestion(string $question): QuestionInterface
    {
        return $this->setData(self::QUESTION, $question);
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return QuestionInterface
     */
    public function setAnswer(string $answer): QuestionInterface
    {
        return $this->setData(self::ANSWER, $answer);
    }

    /**
     * Set status
     *
     * @param int $status
     * @return QuestionInterface
     */
    public function setStatus(int $status): QuestionInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set position
     *
     * @param int $position
     * @return QuestionInterface
     */
    public function setPosition(int $position): QuestionInterface
    {
        return $this->setData(self::POSITION, $position);
    }
}
