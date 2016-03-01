<?php
namespace DOMNavigator\Loader;

class URLLoader implements LoaderInterface
{
	/**
	 * @var FileLoader
	 */
	private $fileLoader;

	/**
	 * Aggregate with FileLoader for delegate load method
	 *
	 * @param FileLoader $fileLoader
	 */
	public function __construct(FileLoader $fileLoader)
	{
		$this->fileLoader = $fileLoader;
	}

	/**
	 * Load document by url.
	 *
	 * @param string $content
	 * @param string $encoding
	 * @param int $type
	 *
	 * @return \DOMDocument
	 */
	public function load($content, $encoding = 'utf-8', $type = self::TYPE_HTML)
	{
		return $this->fileLoader->load($content, $encoding, $type);
	}
}