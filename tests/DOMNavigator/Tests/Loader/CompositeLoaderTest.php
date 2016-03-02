<?php
namespace DOMNavigator\Tests\Loader;

use DOMNavigator\Loader\CompositeLoader;
use DOMNavigator\Loader\FileLoader;
use DOMNavigator\Loader\LoaderInterface;
use DOMNavigator\Loader\StringLoader;
use DOMNavigator\Loader\URLLoader;

class CompositeLoaderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \DOMNavigator\Exception\LogicException
	 */
	public function testLoadWhiteoutLoaders()
	{
		$loader = new CompositeLoader();
		$loader->load(DOMNAVIGATOR_FIXTURES_DIR.'/document.html');
	}

	/**
	 * @dataProvider loaderMockProvider
	 */
	public function testSetLoaderFromConstructAndCallingOrder()
	{
		/** @var \PHPUnit_Framework_MockObject_MockObject[] $loaders */
		$loaders = func_get_args();
		$content = '<?xml version="1.0" encoding="utf-8"?><body></body>';
		$type = LoaderInterface::TYPE_XML;

		foreach ($loaders as $key => $simpleLoader)
			$simpleLoader
				->expects($this->at($key))
				->method('load')
				->with(
					$this->equalTo($content),
					$this->equalTo($type)
				);

		$loader = new CompositeLoader($loaders);

		$loader->load($content, $type);
	}

	/**
	 * @dataProvider loaderMockProvider
	 */
	public function testSetSetLoaderWithAddMethodAndCallingOrder()
	{
		/** @var \PHPUnit_Framework_MockObject_MockObject[] $loaders */
		$loaders = func_get_args();
		$content = '<?xml version="1.0" encoding="utf-8"?><body></body>';
		$type = LoaderInterface::TYPE_XML;
		$loader = new CompositeLoader();

		foreach ($loaders as $key => $simpleLoader) {
			$simpleLoader
				->expects($this->at($key))
				->method('load')
				->with(
					$this->equalTo($content),
					$this->equalTo($type)
				);
			$loader->addLoader($simpleLoader);
		}

		$loader->load($content, $type);
	}

	/**
	 * @dataProvider documentProvider
	 * @param string $file
	 * @param string $type
	 */
	public function testRealLoadWithFileLoader($file, $type)
	{
		$loader = new CompositeLoader([new FileLoader()]);
		$document = $loader->load($file, $type);

		$this->assertNotNull($document);
		$this->assertInstanceOf(\DOMDocument::class, $document);
	}

	/**
	 * @dataProvider loaderProvider
	 */
	public function testTryToLoadAnyResources()
	{
		$resources = [
			DOMNAVIGATOR_FIXTURES_DIR.'/document.html',
			'http://google.com',
			'<?xml version="1.0" encoding="utf-8"?><body></body>'
		];

		$compositeLoader = new CompositeLoader(func_get_args());

		foreach ($resources as $resource) {
			$document = $compositeLoader->load($resource);

			$this->assertNotNull($document);
			$this->assertInstanceOf(\DOMDocument::class, $document);
		}
	}

	public function loaderMockProvider()
	{
		$loader1 = $this->getMock(LoaderInterface::class);
		$loader2 = $this->getMock(LoaderInterface::class);
		$loader3 = $this->getMock(LoaderInterface::class);

		return [
			[$loader1, $loader2, $loader3],
			[$loader3, $loader2, $loader1],
			[$loader2, $loader3, $loader1]
		];
	}

	public function loaderProvider()
	{
		$fileLoader = new FileLoader();
		$stringLoader = new StringLoader();
		$urlLoader = new URLLoader($stringLoader);

		return [
			[$fileLoader, $urlLoader, $stringLoader],
			[$stringLoader, $urlLoader, $fileLoader],
			[$urlLoader, $stringLoader, $fileLoader]
		];
	}

	public function documentProvider()
	{
		return [
			[DOMNAVIGATOR_FIXTURES_DIR.'/document.html', LoaderInterface::TYPE_HTML],
			[DOMNAVIGATOR_FIXTURES_DIR.'/document.xml', LoaderInterface::TYPE_XML]
		];
	}
}