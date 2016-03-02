<?php
namespace DOMNavigator\Tests\Loader;

use DOMNavigator\Loader\LoaderInterface;
use DOMNavigator\Loader\StringLoader;

class StringLoaderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var StringLoader
	 */
	protected $loader;

	public function setUp()
	{
		$this->loader = new StringLoader();
	}

	/**
	 * @dataProvider contentProvider
	 * @param string $content
	 * @param string $type
	 */
	public function testLoad($content, $type)
	{
		$document = $this->loader->load($content, $type);

		$this->assertNotNull($document);
		$this->assertInstanceOf(\DOMDocument::class, $document);
	}

	public function testLoadWithMissedXmlTag()
	{
		$content = file_get_contents(DOMNAVIGATOR_FIXTURES_DIR.'/document-with-missed.xml');
		$document = $this->loader->load($content, LoaderInterface::TYPE_XML);

		$this->assertNotNull($document);
		$this->assertInstanceOf(\DOMDocument::class, $document);
	}

	public function contentProvider()
	{
		return [
			[file_get_contents(DOMNAVIGATOR_FIXTURES_DIR.'/document.html'), LoaderInterface::TYPE_HTML],
			[file_get_contents(DOMNAVIGATOR_FIXTURES_DIR.'/document.xml'), LoaderInterface::TYPE_XML]
		];
	}
}