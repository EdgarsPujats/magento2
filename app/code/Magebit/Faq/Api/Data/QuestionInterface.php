<?php

namespace Magebit\Faq\Api\Data;

/**
 * FAQ question interface.
 * @api
 * @since 100.0.2
 */
interface QuestionInterface
{
    /**#@+
     * Constants for keys of data array.
     */
    const MAIN_TABLE = 'faq_question';
    const QUESTION_ID = 'id';
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const STATUS = 'status';
    const POSITION = 'position';
    const UPDATED_AT = 'updated_at';
    /**#@-*/

    /**
     * Get ID
     *
     * @return ?int
     */
    public function getId(): ?int;

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion(): string;

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer(): string;

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition(): int;

    /**
     * Set question
     *
     * @param string $question
     * @return QuestionInterface
     */
    public function setQuestion(string $question): QuestionInterface;

    /**
     * Set answer
     *
     * @param string $answer
     * @return QuestionInterface
     */
    public function setAnswer(string $answer): QuestionInterface;

    /**
     * Set status
     *
     * @param int $status
     * @return QuestionInterface
     */
    public function setStatus(int $status): QuestionInterface;

    /**
     * Set position
     *
     * @param int $position
     * @return QuestionInterface
     */
    public function setPosition(int $position): QuestionInterface;
}

