<?php
namespace Dibber\Document\Mapper;

use \Doctrine\ODM\MongoDB\DocumentManager;

abstract class Base
{
    /** @var \Doctrine\ODM\MongoDB\DocumentManager */
    protected $dm;

    /**
     * FQDN of the document
     *
     * @var string
     */
    protected $documentName;

    /**
     * @param \Doctrine\ODM\MongoDB\DocumentManager $dm
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
     * @return \Doctrine\ODM\MongoDB\DocumentManager
     */
    public function getDocumentManager()
    {
        return $this->dm;
    }

    /**
     * @param \Doctrine\ODM\MongoDB\DocumentManager $dm
     * @return \Dibber\Document\Mapper\Base
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
     * @return \Dibber\Document\Mapper\Base
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
     * @return \Doctrine\ODM\MongoDB\DocumentRepository
     */
    public function getRepository($documentName = null)
    {
        if (is_null($documentName)) {
            $documentName = $this->getDocumentName();
        }
        return $this->dm->getRepository($documentName);
    }

    /**
     * @param array $data
     * @param \Dibber\Document\Base $document
     * @return \Dibber\Document\Base
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
     * @return Dibber\Document\Base
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
     * @return Dibber\Document\Base
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @param array $criteria
     * @return Dibber\Document\Base
     */
    public function findOneBy(array $criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    /**
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
     * @param array|\Dibber\Document\Base $document
     * @param bool $flush
     * @return Dibber\Document\Base
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
     * @param string|array|\Dibber\Document\Base $document
     * @param bool $flush
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