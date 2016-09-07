<?php
namespace DOMNavigator\Tests\Loader;

use DOMNavigator\Loader\LoaderInterface;
use DOMNavigator\Loader\StringLoader;
use DOMNavigator\Loader\URLLoader;

class URLLoaderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var URLLoader
	 */
	protected $loader;

	public function setUp()
	{
		$this->loader = new URLLoader(new StringLoader());
	}

	public function tearDown()
	{
		$cookieFile = DOMNAVIGATOR_FIXTURES_DIR.'/dmn-cookies';

		file_exists($cookieFile) && unlink($cookieFile);
	}

	/**
	 * @dataProvider urlProvider
	 * @param string $url
	 * @param string $type
	 */
	public function testLoad($url, $type)
	{
		$document = $this->loader->load($url, $type);

		$this->assertNotNull($document);
		$this->assertInstanceOf('\DOMDocument', $document);
	}

	/**
	 * @expectedException \DOMNavigator\Exception\InvalidArgumentException
	 * @dataProvider wrongUrlProvider
	 * @param string $url
	 */
	public function testLoadWrongUrl($url)
	{
		$this->loader->load($url);
	}

	/**
	 * @expectedException \DOMNavigator\Exception\UnexpectedValueException
	 * @dataProvider unknownFileProvider
	 * @param string $url
	 */
	public function testLoadUnknownFile($url)
	{
		$this->loader->load($url);
	}

	public function testLoadWithCookieUsing()
	{
		$url = 'http://google.com';
		$type = LoaderInterface::TYPE_HTML;

		$this->loader = new URLLoader(new StringLoader(), [
			'cookieSavePath' => DOMNAVIGATOR_FIXTURES_DIR
		]);

		$this->loader->load($url, $type);
		$this->assertTrue(file_exists(DOMNAVIGATOR_FIXTURES_DIR.'/dmn-cookies'));
	}

	public function urlProvider()
	{
		return [
			['http://google.com', LoaderInterface::TYPE_HTML],
			['http://facebook.com/', LoaderInterface::TYPE_HTML],
			['https://google.com/', LoaderInterface::TYPE_HTML]
		];
	}

	public function wrongUrlProvider()
	{
		return [
			['http:google.com'],
			['://facebook.com/']
		];
	}

	public function unknownFileProvider()
	{
		return [
			['http://google.com/how/get/this/file'],
			['http://yandex.ru/this/page/not/found']
		];
	}
}