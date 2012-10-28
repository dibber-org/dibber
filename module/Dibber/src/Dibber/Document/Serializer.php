<?php
/**
 * @see         https://github.com/borisguery/bgylibrary/blob/master/library/Bgy/Doctrine/EntitySerializer.php
 * @see         https://gist.github.com/1034079#file_serializable_entity.php
 */

namespace Dibber\Document;

use Doctrine\Common\Util\Inflector
 ,  Doctrine\ODM\MongoDB\DocumentManager;

class Serializer
{
    /**
     * @var Doctrine\ODM\MongoDB\DocumentManager
     */
    protected $dm;

    /**
     * @var int
     */
    protected $recursionDepth = 0;

    /**
     * @var int
     */
    protected $maxRecursionDepth = 2;

    public function __construct($dm)
    {
        $this->setDocumentManager($dm);
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
     * @return Serializer
     */
    public function setDocumentManager(DocumentManager $dm)
    {
        $this->dm = $dm;

        return $this;
    }

    /**
     * Get the maximum recursion depth
     *
     * @return  int
     */
    public function getMaxRecursionDepth()
    {
        return $this->maxRecursionDepth;
    }

    /**
     * Set the maximum recursion depth
     *
     * @param   int     $maxRecursionDepth
     * @return  void
     */
    public function setMaxRecursionDepth($maxRecursionDepth)
    {
        $this->maxRecursionDepth = $maxRecursionDepth;
    }

    protected function serialize($document)
    {
        $className = get_class($document);
        $metadata = $this->dm->getClassMetadata($className);

        $data = array();

        foreach ($metadata->fieldMappings as $field => $mapping) {
            $value = $metadata->reflFields[$field]->getValue($document);
            $field = Inflector::tableize($field);
            if ($value instanceof \Traversable) {
                if ($this->recursionDepth < $this->maxRecursionDepth) {
                    $this->recursionDepth++;
                    foreach ($value as $v) {
                        $data[$field][] = $this->serialize($v);
                    }
                    $this->recursionDepth--;
                }
            }
            else if ($value instanceof \DateTime) {
                $data[$field] = $value->format(\DateTime::ATOM);
            }
            else if (is_object($value)) {
                if ($this->recursionDepth < $this->maxRecursionDepth) {
                    $this->recursionDepth++;
                    $data[$field] = $this->serialize($value);
                    $this->recursionDepth--;
                }
            }
            else {
                $data[$field] = $value;
            }
        }

        return $data;
    }

    /**
     * Serialize a document to an array
     *
     * @param Document\Base $document
     * @return array
     */
    public function toArray($document)
    {
        return $this->serialize($document);
    }

    /**
     * Convert a document to a JSON object
     *
     * @param Document\Base $document
     * @return string
     */
    public function toJson($document)
    {
        return json_encode($this->toArray($document));
    }
}