<?php
namespace DOMNavigator\Tests\Loader;

use DOMNavigator\Loader\FileLoader;
use DOMNavigator\Loader\URLLoader;

class URLLoaderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var URLLoader
	 */
	protected $loader;

	public function setUp()
	{
		$this->loader = new URLLoader(new FileLoader());
	}

	/**
	 * @dataProvider urlProvider
	 */
	public function testLoad()
	{

	}

	public function urlProvider()
	{
		return [

		];
	}
}