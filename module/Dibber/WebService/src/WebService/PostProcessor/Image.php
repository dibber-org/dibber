<?php

namespace Dibber\WebService\PostProcessor;

/**
 *
 */
class Image extends AbstractPostProcessor
{
    public function process()
    {
        $result = $this->vars['image'];

        $this->response->setContent($result);

        $headers = $this->response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'image/' . $this->vars['type']);
        $headers->addHeaderLine('Cache-Control', 'max-age=86400');
        $this->response->setHeaders($headers);
    }
}