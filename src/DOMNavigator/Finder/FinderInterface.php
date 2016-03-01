<?php
namespace DOMNavigator\Finder;

interface FinderInterface
{
    /**
     * Set document, where finder search elements
     *
     * @param \DOMDocument $document
     */
    public function setDocument(\DOMDocument $document);

    /**
     * Find nodes in context by query
     *
     * @param string $query
     * @param \DOMElement|null $context
     *
     * @return \DOMNodeList
     */
    public function find($query, \DOMElement $context = null);
}