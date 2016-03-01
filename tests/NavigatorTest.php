<?php
namespace DOMNavigator;

use DOMNavigator\Finder\XPathFinder;
use DOMNavigator\Loader\FileLoader;

class NavigatorTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $loader = new FileLoader();
        $finder = new XPathFinder();

        $domNavigator = new Navigator($loader, $finder);
        $domNavigator->load('/abs/test.html');

        $elements = $domNavigator->navigate('//div[@id=name]');
    }
}