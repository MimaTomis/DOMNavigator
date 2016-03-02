<?php
namespace DOMNavigator\Tests\Finder;

use DOMNavigator\Finder\XPathFinder;

class XPathFinderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var XPathFinder
	 */
	protected $finder;

	public function setUp()
	{
		$this->finder = new XPathFinder();
	}

	/**
	 * @expectedException \DOMNavigator\Exception\LogicException
	 */
	public function testFindInUnknownDocument()
	{
		$this->finder->find('//body');
	}

	public function testFindUnknownElement()
	{
		$document = new \DOMDocument();
		$document->load(DOMNAVIGATOR_FIXTURES_DIR.'/document.xml');

		$this->finder->setDocument($document);
		$elements = $this->finder->find('//xzkakoyelement');

		$this->assertNotNull($elements);
		$this->assertEquals(0, $elements->length);
	}

	/**
	 * @dataProvider xpathHTMLProvider
	 *
	 * @param string $query
	 * @param string $name
	 * @param int $count
	 */
	public function testFindInHTML($query, $name, $count)
	{
		$names = explode(',', $name);

		$document = new \DOMDocument();
		$document->loadHTMLFile(DOMNAVIGATOR_FIXTURES_DIR.'/document.html');

		$this->finder->setDocument($document);

		$elements = $this->finder->find($query);

		$this->assertEquals($count, $elements->length);
		$this->assertContainsOnlyInstancesOf(\DOMNode::class, $elements);

		foreach ($elements as $element) {
			$nodeName = mb_strtolower($element->nodeName);
			$this->assertContains($nodeName, $names);
		}
	}

	/**
	 * @dataProvider xpathXMLProvider
	 *
	 * @param string $query
	 * @param string $name
	 * @param int $count
	 */
	public function testFindInXML($query, $name, $count)
	{
		$names = explode(',', $name);

		$document = new \DOMDocument();
		$document->load(DOMNAVIGATOR_FIXTURES_DIR.'/document.xml');

		$this->finder->setDocument($document);
		$elements = $this->finder->find($query);

		$this->assertEquals($count, $elements->length);
		$this->assertContainsOnlyInstancesOf(\DOMNode::class, $elements);

		foreach ($elements as $element) {
			$nodeName = mb_strtolower($element->nodeName);
			$this->assertContains($nodeName, $names);
		}
	}

	/**
	 * @dataProvider xpathWithContextProvider
	 * @param string $context
	 * @param string $query
	 * @param string $name
	 * @param int $count
	 */
	public function testFindInContext($context, $query, $name, $count)
	{
		$names = explode(',', $name);

		$document = new \DOMDocument();
		$document->load(DOMNAVIGATOR_FIXTURES_DIR.'/document.xml');

		$this->finder->setDocument($document);
		$context = $this->finder->find($context);
		$context = $context->item(0);

		$elements = $this->finder->find($query, $context);

		$this->assertEquals($count, $elements->length);
		$this->assertContainsOnlyInstancesOf(\DOMNode::class, $elements);

		foreach ($elements as $element) {
			$nodeName = mb_strtolower($element->nodeName);
			$this->assertContains($nodeName, $names);
		}
	}

	public function xpathHTMLProvider()
	{
		return [
			['//*[@id=\'content\']', 'div', 1],
			['//h1', 'h1', 1],
			['//ul/li', 'li', 2],
			['//*[@href]', 'a', 1],
			['//div[@id=\'footer\']/ul/@data-type', 'data-type', 1],
			['//div|//@href', 'div,href', 3]
		];
	}

	public function xpathXMLProvider()
	{
		return [
			['//body/content', 'content', 1],
			['//body/*', 'header,content,link', 3],
			['//@*', 'href,data-name', 2],
			['//*[@*]', 'link,list', 2],
			['//body|//list/@data-name', 'body,data-name', 2]
		];
	}

	public function xpathWithContextProvider()
	{
		return [
			['//body', 'content/paragraph', 'paragraph', 3],
			['//list', '//item', 'item', 2],
			['//link', '@href', 'href', 1]
		];
	}
}