<?php
namespace DOMNavigator\Tests;

use DOMNavigator\Finder\XPathFinder;
use DOMNavigator\Loader\FileLoader;
use DOMNavigator\Navigator;

class NavigatorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Navigator
	 */
	protected $navigator;

	public function setUp()
	{
		$this->navigator = new Navigator(new FileLoader(), new XPathFinder());
	}

	/**
	 * @expectedException \DOMNavigator\Exception\LogicException
	 */
	public function testNavigateWithoutLoading()
	{
		$this->navigator->navigate('//body');
	}

	/**
	 * @dataProvider queryProvider
	 * @param string $file
	 * @param string $query
	 * @param string $name
	 */
	public function testNavigate($file, $query, $name)
	{
		$this->navigator->loadHTML($file);
		$elements = $this->navigator->navigate($query);

		$this->assertGreaterThan(0, $elements->length);
		$this->assertContainsOnlyInstancesOf(\DOMNode::class, $elements);

		foreach ($elements as $element)
			$this->assertEquals($name, $element->nodeName);
	}

	/**
	 * @dataProvider queryWithContextProvider
	 * @param string $file
	 * @param string $context
	 * @param string $query
	 * @param string $name
	 */
	public function testNavigateWithContext($file, $context, $query, $name)
	{
		$this->navigator->loadHTML($file);

		$context = $this->navigator->navigate($context);
		$context = $context->item(0);

		$elements = $this->navigator->navigate($query, $context);

		$this->assertGreaterThan(0, $elements->length);
		$this->assertContainsOnlyInstancesOf(\DOMNode::class, $elements);

		foreach ($elements as $element)
			$this->assertEquals($name, $element->nodeName);
	}

	public function queryProvider()
	{
		return [
			[DOMNAVIGATOR_FIXTURES_DIR.'/document.html', '//div', 'div'],
			[DOMNAVIGATOR_FIXTURES_DIR.'/document.html', '//ul/li', 'li']
		];
	}

	public function queryWithContextProvider()
	{
		return [
			[DOMNAVIGATOR_FIXTURES_DIR.'/document.html', '//div[@id=\'content\']', 'p', 'p'],
			[DOMNAVIGATOR_FIXTURES_DIR.'/document.html', '//ul', '//li', 'li'],
			[DOMNAVIGATOR_FIXTURES_DIR.'/document.html', '//*[@id=\'footer\']/ul', '@data-type', 'data-type']
		];
	}
}