<?php
namespace DOMNavigator\Tests\Loader;

use DOMNavigator\Loader\FileLoader;

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
}