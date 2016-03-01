<?php
namespace DOMNavigator\Finder;

class XPathFinder implements FinderInterface
{
    /**
     * Find nodes in context by query
     *
     * @param string $query
     * @param \DOMElement|\DOMNode $context
     *
     * @return \DOMNodeList
     */
    public function find($query, \DOMNode $context)
    {
        if ($context instanceof \DOMDocument) {
            $document = $context;
            $context = null;
        } else {
            $document = $context->ownerDocument;
        }

        $xpath = new \DOMXPath($document);

        return $xpath->query($query, $context);
    }
}