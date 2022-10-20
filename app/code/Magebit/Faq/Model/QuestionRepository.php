<?php

declare(strict_types=1);

namespace Magebit\Faq\Model;

use Exception;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\Data\QuestionInterfaceFactory;
use Magebit\Faq\Api\Data\QuestionSearchResultsInterface;
use Magebit\Faq\Api\Data\QuestionSearchResultsInterfaceFactory;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Model\ResourceModel\Question as ResourceQuestion;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\EntityManager\HydratorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Default question repo impl.
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var ResourceQuestion
     */
    protected $resource;

    /**
     * @var QuestionFactory
     */
    protected $questionFactory;

    /**
     * @var QuestionCollectionFactory
     */
    protected $questionCollectionFactory;

    /**
     * @var f
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var QuestionInterfaceFactory
     */
    protected $dataQuestionFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @param ResourceQuestion $resource
     * @param QuestionFactory $questionFactory
     * @param QuestionInterfaceFactory $dataQuestionFactory
     * @param QuestionCollectionFactory $questionCollectionFactory
     * @param QuestionSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param HydratorInterface|null $hydrator
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        ResourceQuestion                               $resource,
        QuestionFactory                                $questionFactory,
        QuestionInterfaceFactory $dataQuestionFactory,
        QuestionCollectionFactory                      $questionCollectionFactory,
        QuestionSearchResultsInterfaceFactory     $searchResultsFactory,
        DataObjectHelper                            $dataObjectHelper,
        DataObjectProcessor                         $dataObjectProcessor,
        StoreManagerInterface                       $storeManager,
        CollectionProcessorInterface                $collectionProcessor = null,
        ?HydratorInterface                          $hydrator = null
    ) {
        $this->resource = $resource;
        $this->questionFactory = $questionFactory;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataQuestionFactory = $dataQuestionFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor ?? ObjectManager::getInstance()->get(CollectionProcessorInterface::class);
        $this->hydrator = $hydrator ?? ObjectManager::getInstance()->get(HydratorInterface::class);
    }

    /**
     * Save Question data
     *
     * @param QuestionInterface $question
     * @return Question
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(QuestionInterface $question): QuestionInterface
    {
        if ($question->getId() && $question instanceof Question && !$question->getOrigData()) {
            $question = $this->hydrator->hydrate($this->getById($question->getId()), $this->hydrator->extract($question));
        }

        try {
            $this->resource->save($question);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $question;
    }

    /**
     * Load Question data by given Question ID
     *
     * @param string $questionId
     * @return Question
     * @throws NoSuchEntityException
     */
    public function getById($questionId): QuestionInterface
    {
        $question = $this->questionFactory->create();
        $this->resource->load($question, $questionId);
        if (!$question->getId()) {
            throw new NoSuchEntityException(__('The FAQ question with the "%1" ID doesn\'t exist.', $questionId));
        }
        return $question;
    }

    /**
     * Load Question data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param SearchCriteriaInterface $criteria
     * @return QuestionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): QuestionSearchResultsInterface
    {
        $searchResults = $this->searchResultsFactory->create();
        $collection = $this->questionCollectionFactory->create();
        $this->collectionProcessor->process($criteria, $collection);
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete Question
     *
     * @param QuestionInterface $question
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(QuestionInterface $question): bool
    {
        try {
            $this->resource->delete($question);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Question by given Question ID
     *
     * @param string $questionId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($questionId): bool
    {
        return $this->delete($this->getById($questionId));
    }
}
