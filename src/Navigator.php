<?php
namespace DOMNavigator;

use DOMNavigator\Finder\FinderInterface;
use DOMNavigator\Loader\LoaderInterface;

class Navigator implements NavigatorInterface
{
    public function __construct(array $loaders, FinderInterface $finder)
    {

    }

    public function load($content, $encoding = 'utf-8', $type = LoaderInterface::TYPE_HTML)
    {

    }

    public function navigate($query, \DOMElement $context = null)
    {
        // TODO: Implement navigate() method.
    }
}