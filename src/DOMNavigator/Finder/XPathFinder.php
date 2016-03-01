<?php
namespace DOMNavigator\Finder;

use DOMNavigator\Exception\LogicException;

class XPathFinder extends AbstractFinder
{
    /**
     * Find nodes in context by query
     *
     * @param string $query
     * @param \DOMElement|null $context
     *
     * @return \DOMNodeList
     */
    public function find($query, \DOMElement $context = null)
    {
        if (!$this->document)
            throw new LogicException(sprintf('Document must be set to %s class before calling %s method', __CLASS__, __METHOD__));

        $xpath = new \DOMXPath($this->document);

        return $xpath->query($query, $context);
    }


}