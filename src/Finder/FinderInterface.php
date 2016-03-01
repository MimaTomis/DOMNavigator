<?php
namespace DOMNavigator\Finder;

interface FinderInterface
{
    /**
     * Find nodes in context by query
     *
     * @param string $query
     * @param \DOMElement|\DOMNode $context
     *
     * @return \DOMNodeList
     */
    public function find($query, \DOMNode $context);
}