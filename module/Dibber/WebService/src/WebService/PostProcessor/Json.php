<?php

namespace Dibber\WebService\PostProcessor;

/**
 *
 */
class Json extends AbstractPostProcessor
{
    public function process()
    {
        $result = \Zend\Json\Encoder::encode($this->vars);

        $this->response->setContent($result);

        $headers = $this->response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/json');
        $this->response->setHeaders($headers);
    }
}