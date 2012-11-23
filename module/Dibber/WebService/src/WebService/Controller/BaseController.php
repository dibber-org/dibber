<?php

namespace Dibber\WebService\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

/**
 *
 */
abstract class BaseController extends AbstractRestfulController
{
    /**
     * @var \Dibber\Document\Mapper\Base
     */
    protected $mapper = null;

    /**
     * @return \Dibber\Document\Mapper\Base
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @param mixed $mapper
     * @return \Dibber\WebService\Controller\BaseController
     */
    public function setMapper($mapper)
    {
        if (is_string($mapper)) {
            $this->mapper = $this->getServiceLocator()->get($mapper);
        }
        else {
            $this->mapper = $mapper;
        }

        return $this;
    }

    /**
     * Return list of resources
     *
     * @return array
     */
    public function getList()
    {
        return $this->mapper->toArray($this->mapper->findAll());
    }

    /**
     * Return single resource
     *
     * @param mixed $id
     * @return mixed
     */
    public function get($id)
    {
        $resource = $this->mapper->find($id);
        if (!$resource) {
            throw new \Exception('The requested resource was not found.');
        }

        return $this->mapper->toArray($resource);
    }

    /**
     * Create a new resource
     *
     * @param mixed $data
     * @return mixed
     */
    public function create($data)
    {
        try {
            $resource = $this->mapper->save($data, true);
        }
        catch (\Exception $e) {
            throw new \Exception('The requested resource could not be created');
        }

        return $this->mapper->toArray($resource);
    }

    /**
     * Update an existing resource
     *
     * @param mixed $id
     * @param mixed $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $data['_id'] = $id;
        try {
            $resource = $this->mapper->save($data, true);
        }
        catch (\Exception $e) {
            throw new \Exception('The requested resource could not be updated');
        }

        return $this->mapper->toArray($resource);
    }

    /**
     * Delete an existing resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete($id)
    {
        try {
            $resource = $this->mapper->delete($id, true);
        }
        catch (\Exception $e) {
            throw new \Exception('The requested resource could not be deleted');
        }

        return $this->mapper->toArray($resource);
    }
}
