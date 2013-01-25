<?php
namespace Dibber\Mapper;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Dibber\Document;
use Dibber\EventManager\EventManagerAwareTrait;
use Dibber\EventManager\TriggerEventTrait;
use Zend\EventManager\EventManagerAwareInterface;
use Sds\Common\Serializer;

abstract class Base// implements EventManagerAwareInterface // commented as it makes unit tests seg fault :/
{
    use EventManagerAwareTrait;
    use TriggerEventTrait;

    /** @var DocumentManager */
    protected $dm;

    /**
     * FQDN of the document
     *
     * @var string
     */
    protected $documentName;

    /** @var Serializer\SerializerInterface */
    protected $serializer;

    /**
     * @param string $documentName
     * @param DocumentManager $dm
     */
    public function __construct($documentName = null, DocumentManager $dm = null)
    {
        if ( !is_null($documentName)) {
            $this->setDocumentName($documentName);
        }
        if ( !is_null($dm)) {
            $this->setDocumentManager($dm);
        }
    }

    /**
     * @return DocumentManager
     */
    public function getDocumentManager()
    {
        return $this->dm;
    }

    /**
     * @param DocumentManager $dm
     * @return Base
     */
    public function setDocumentManager(DocumentManager $dm)
    {
        $this->dm = $dm;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentName()
    {
        return $this->documentName;
    }

    /**
     * @param string $documentName
     * @return Base
     * @throws \Exception
     */
    public function setDocumentName($documentName)
    {
        if (false === class_exists($documentName)) {
            // @todo throw good Exception
            throw new \Exception("'".$documentName."' class doesn't exist. Can't create class.");
        }
        $this->documentName = $documentName;
        return $this;
    }

    /**
     * @param string $documentName
     * @return DocumentRepository
     */
    public function getRepository($documentName = null)
    {
        if (is_null($documentName)) {
            $documentName = $this->getDocumentName();
        }
        return $this->dm->getRepository($documentName);
    }

    /**
     * @return Serializer\SerializerInterface
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * @param Serializer\SerializerInterface $serializer
     */
    public function setSerializer(Serializer\SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array|Document\Base $document
     * @return array
     */
    public function serialize($document = null)
    {
        $data = [];
        if (is_null($document)) {
            $document = $this->createDocument();
        }

        if (is_array($document) || $document instanceof \Traversable) {
            // List of documents
            foreach ($document as $d) {
                $data[] = $this->getSerializer()->toArray($d);
            }
        }
        else {
            $data = $this->getSerializer()->toArray($document);
        }

        return $data;
    }

    /**
     * Alias to serialize()
     *
     * @param array|Document\Base $document
     * @return array
     */
    public function toArray($document = null)
    {
        return $this->serialize($document);
    }

    /**
     * @param array $data
     * @param Document\Base $document
     * @return Document\Base
     */
    public function hydrate($data, $document = null)
    {
        if (is_null($document)) {
            $document = $this->createDocument();
        }

        # Gives the possibility to change $argv in listeners
        $argv = array('data' => &$data, 'document' => $document);
        $this->triggerEvent('hydrate.pre', $argv);
        extract($argv);

        $this->dm->getHydratorFactory()->hydrate($document, $data);

        $this->triggerEvent('hydrate.post', $argv);

        return $document;
    }

    /**
     *
     */
    public function flush()
    {
        $this->dm->flush();
    }

    /**
     * Creates a new instance of the given documentName or of the already known
     * one whose FQDN is stored in the className property.
     *
     * @return Document\Base
     * @throws \Exception
     */
    public function createDocument($documentName = null)
    {
        if (is_null($documentName)) {
            $documentName = $this->getDocumentName();
            if ( !$documentName) {
                // @todo throw good Exception
                throw new \Exception("documentName not set. Can't create class.");
            }
        } else {
            if (false === class_exists($documentName)) {
                // @todo throw good Exception
                throw new \Exception("'".$documentName."' class doesn't exist. Can't create class.");
            }
        }

        return new $documentName;
    }

    /**
     * @param string $id
     * @return Document\Base
     *
     * @triggers find.pre
     * @triggers find.post
     * @triggers find
     */
    public function find($id)
    {
        # Gives the possibility to change $argv in listeners
        $argv = array('id' => &$id);
        $this->triggerEvent('find.pre', $argv);
        extract($argv);

        $document = $this->getRepository()->find($id);

        $this->triggerEvent('find', ['document' => $document]);
        $this->triggerEvent('find.post', ['id' => $id, 'document' => $document]);

        return $document;
    }

    /**
     * @param array $criteria
     * @return Document\Base
     *
     * @triggers findOneBy.pre
     * @triggers findOneBy.post
     * @triggers find
     */
    public function findOneBy(array $criteria)
    {
        # Gives the possibility to change $argv in listeners
        $argv = array('criteria' => &$criteria);
        $this->triggerEvent('findOneBy.pre', $argv);
        extract($argv);

        $document = $this->getRepository()->findOneBy($criteria);

        $this->triggerEvent('find', ['document' => $document]);
        $this->triggerEvent('findOneBy.post', ['criteria' => $criteria, 'document' => $document]);

        return $document;
    }

    /**
     * @param array|string $orderBy
     * @return array
     *
     * @triggers findAll.pre
     * @triggers findAll.post
     * @triggers find
     */
    public function findAll($orderBy = null)
    {
        if (is_string($orderBy)) {
            $orderBy = [$orderBy => 'asc'];
        }

        # Gives the possibility to change $argv in listeners
        $argv = ['orderBy' => &$orderBy];
        $this->triggerEvent('findAll.pre', $argv);
        extract($argv);

        $documents = $this->getRepository()->findBy([], $orderBy);

        foreach ($documents as $document) {
            $this->triggerEvent('find', ['document' => $document]);
        }

        $this->triggerEvent('findAll.post', ['orderBy' => $orderBy, 'documents' => $documents]);

        return $documents;
    }

    /**
     * @param array $criteria
     * @param array|string $orderBy
     * @param int $limit
     * @param int $offset
     * @return array
     *
     * @triggers findBy.pre
     * @triggers findBy.post
     * @triggers find
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        if (is_string($orderBy)) {
            $orderBy = [$orderBy => 'asc'];
        }

        # Gives the possibility to change $argv in listeners
        $argv = array('criteria' => &$criteria, 'orderBy' => &$orderBy, 'limit' => &$limit, 'offset' => &$offset);
        $this->triggerEvent('findBy.pre', $argv);
        extract($argv);

        $documents = $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);

        foreach ($documents as $document) {
            $this->triggerEvent('find', ['document' => $document]);
        }

        $this->triggerEvent('findBy.post', array_merge($argv, ['documents' => $documents]));

        return $documents;
    }

    /**
     * @param array|Document\Base $document
     * @param bool $flush
     * @return Document\Base
     */
    public function save($document, $flush = false)
    {
        # Gives the possibility to change $argv in listeners
        $argv = array('document' => &$document, 'flush' => &$flush);
        $this->triggerEvent('save.pre', $argv);
        extract($argv);

        if (is_array($document)) {
            # Means we only have an array of data here
            $data = $document;
            $document = null;
            if (array_key_exists('_id', $data) && !empty($data['_id'])) {
                # We have an id here > it's an update !
                $document = $this->find($data['_id']);
                unset($data['_id']);
            }
            $document = $this->hydrate($data, $document);
        }

        $this->dm->persist($document);

        if ($flush == true) {
            $this->flush();
        }

        $this->triggerEvent('save.post', array_merge($argv, ['saved' => $document]));

        return $document;
    }

    /**
     * @param string|array|Document\Base $document
     * @param bool $flush
     * @return Document\Base
     */
    public function delete($document, $flush = false)
    {
        # Gives the possibility to change $argv in listeners
        $argv = array('document' => &$document, 'flush' => &$flush);
        $this->triggerEvent('delete.pre', $argv);
        extract($argv);

        if (is_string($document)) {
            # Means we only have the id of the document
            $document = $this->find($document);
        } else if (is_array($document)) {
            # Means we only have criteria precise enough to get the document
            $document = $this->findOneBy($document);
        }

        $this->dm->remove($document);

        if ($flush == true) {
            $this->flush();
        }

        $this->triggerEvent('delete.post', array_merge($argv, ['deleted' => $document]));

        return $document;
    }
}