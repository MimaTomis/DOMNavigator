<?php
namespace DOMNavigator;

use DOMNavigator\Finder\FinderInterface;
use DOMNavigator\Loader\LoaderInterface;

class Navigator implements NavigatorInterface
{
    /**
     * @var LoaderInterface
     */
    private $loader;
    /**
     * @var FinderInterface
     */
    private $finder;

    public function __construct(LoaderInterface $loader, FinderInterface $finder)
    {
        $this->setLoader($loader);
        $this->setFinder($finder);
    }

    /**
     * Set document loader
     *
     * @param LoaderInterface $loader
     *
     * @return $this
     */
    public function setLoader(LoaderInterface $loader)
    {
        $this->loader = $loader;

        return $this;
    }

    /**
     * Set finder service
     *
     * @param FinderInterface $finder
     *
     * @return $this
     */
    public function setFinder(FinderInterface $finder)
    {
        $this->finder = $finder;

        return $this;
    }

    /**
     * Load html document by url, file path or string content
     *
     * @param string $content
     * @param string $encoding
     *
     * @return $this
     */
    public function loadHTML($content, $encoding = 'utf-8')
    {
        $document = $this->loader->load($content, $encoding, LoaderInterface::TYPE_HTML);
        $this->finder->setDocument($document);

        return $this;
    }

    /**
     * Load xml document by url, file path or string content
     *
     * @param string $content
     * @param string $encoding
     *
     * @return $this
     */
    public function loadXML($content, $encoding = 'utf-8')
    {
        $document = $this->loader->load($content, $encoding, LoaderInterface::TYPE_XML);
        $this->finder->setDocument($document);

        return $this;
    }

    /**
     * Navigate in loaded document
     *
     * @param $query
     * @param \DOMElement|null $context
     *
     * @return \DOMNodeList
     */
    public function navigate($query, \DOMElement $context = null)
    {
        return $this->finder->find($query, $context);
    }
}