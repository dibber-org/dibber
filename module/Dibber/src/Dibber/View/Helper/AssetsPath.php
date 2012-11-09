<?php
namespace Dibber\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Helper for retrieving the assets path.
 *
 * @package    Dibber_View
 * @subpackage Helper
 */
class AssetsPath extends AbstractHelper
{
    /**
     * Assets path.
     *
     * @var string
     */
    protected $assetsPath;

    /**
     * Returns site's base path, or file with base path prepended.
     *
     * $file is appended to the base path for simplicity.
     *
     * @param  string|null $file
     * @return string
     */
    public function __invoke($file = null)
    {
        if (null === $this->assetsPath) {
            $this->setAssetsPath($this->view->basePath() . '/assets');
        }

        if (null !== $file) {
            $file = '/' . ltrim($file, '/');
        }

        return $this->assetsPath . $file;
    }

    /**
     * Set the assets path.
     *
     * @param  string $assetsPath
     * @return self
     */
    public function setAssetsPath($assetsPath)
    {
        $this->assetsPath = rtrim($assetsPath, '/');
        return $this;
    }
}
