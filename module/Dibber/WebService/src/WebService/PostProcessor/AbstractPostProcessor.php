<?php

namespace Dibber\WebService\PostProcessor;

/**
 *
 */
abstract class AbstractPostProcessor
{
    /**
     * @var null|array
     */
    protected $vars = null;

    /**
     * @var null|\Zend\Http\Response
     */
    protected $response = null;

    /**
     * @param $vars
     * @param \Zend\Http\Response $response
     */
    public function __construct(\Zend\Http\Response $response = null, $vars = null)
    {
        $this->vars = $vars;
        $this->response = $response;
    }

    /**
     * @param \Zend\Http\Response $response
     * @return AbstractPostProcessor
     */
    public function setResponse(\Zend\Http\Response $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return null|\Zend\Http\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param array $vars
     * @return AbstractPostProcessor
     */
    public function setVars($vars)
    {
        $this->vars = $vars;
        return $this;
    }

    /**
     * @return array
     */
    public function getVars()
    {
        return $this->vars;
    }

    /**
     * @abstract
     */
    abstract public function process();
}