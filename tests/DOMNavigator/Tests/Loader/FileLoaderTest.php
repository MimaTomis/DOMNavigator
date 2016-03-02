<?php
namespace DOMNavigator\Tests\Loader;

use DOMNavigator\Loader\FileLoader;
use DOMNavigator\Loader\LoaderInterface;

class FileLoaderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var FileLoader
	 */
	protected $loader;

	public function setUp()
	{
		$this->loader = new FileLoader();
	}

	/**
	 * @dataProvider fileProvider
	 * @param string $file
	 * @param string $type
	 */
	public function testLoad($file, $type)
	{
		$document = $this->loader->load($file, $type);

		$this->assertNotNull($document);
		$this->assertInstanceOf(\DOMDocument::class, $document);
	}

	/**
	 * @expectedException \DOMNavigator\Exception\InvalidArgumentException
	 */
	public function testLoadUnknownFile()
	{
		$this->loader->load(DOMNAVIGATOR_FIXTURES_DIR.'/unknown.pdf');
	}

	/**
	 * @expectedException \DOMNavigator\Exception\LogicException
	 * @dataProvider wrongFileProvider
	 * @param string $file
	 * @param string $type
	 */
	public function testTryToLoadWithWrongType($file, $type)
	{
		$this->loader->load($file, $type);
	}

	public function fileProvider()
	{
		return [
			[DOMNAVIGATOR_FIXTURES_DIR.'/document.xml', LoaderInterface::TYPE_XML],
			[DOMNAVIGATOR_FIXTURES_DIR.'/document.html', LoaderInterface::TYPE_HTML]
		];
	}

	public function wrongFileProvider()
	{
		return [
			[DOMNAVIGATOR_FIXTURES_DIR.'/document.xml', LoaderInterface::TYPE_HTML],
			[DOMNAVIGATOR_FIXTURES_DIR.'/document.html', LoaderInterface::TYPE_XML],
			[DOMNAVIGATOR_FIXTURES_DIR.'/document.pdf', LoaderInterface::TYPE_XML]
		];
	}
}