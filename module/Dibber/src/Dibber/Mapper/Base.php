<?php
namespace Dibber\Mapper;

use \Doctrine\ODM\MongoDB\DocumentManager
 ,  \Doctrine\ODM\MongoDB\DocumentRepository
 ,  \Dibber\Document
 ,  \Sds\Common\Serializer
 ,  Zend\EventManager;

abstract class Base// implements EventManager\EventManagerAwareInterface // commented as it makes unit tests seg fault :/
{
    use EventManager\EventManagerAwareTrait;

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

        $this->dm->getHydratorFactory()->hydrate($document, $data);

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
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @param array $criteria
     * @return Document\Base
     */
    public function findOneBy(array $criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    /**
     * @param array $orderBy
     * @return array
     */
    public function findAll(array $orderBy = null)
    {
        return $this->getRepository()->findBy([], $orderBy);
    }

    /**
     * @param array $criteria
     * @return array
     */
    public function findBy(array $criteria)
    {
        return $this->getRepository()->findBy($criteria);
    }

    /**
     * @param array|Document\Base $document
     * @param bool $flush
     * @return Document\Base
     */
    public function save($document, $flush = false)
    {
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

        return $document;
    }

    /**
     * @param string|array|Document\Base $document
     * @param bool $flush
     * @return Document\Base
     */
    public function delete($document, $flush = false)
    {
        if (is_string($document)) {
            # Means we only have the id of the document
            $document = $this->find($document);
        } else if (is_array($document)) {
            # Means we only have criteria precise enough to get the document
            $document = $this->findOneBy($document);
        }

        $this->dm->remove($document);

        $this->dm->persist($document);

        if ($flush == true) {
            $this->flush();
        }

        return $document;
    }
}