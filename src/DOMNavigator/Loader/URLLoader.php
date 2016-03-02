<?php
namespace DOMNavigator\Loader;

use DOMNavigator\Exception\InvalidArgumentException;

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
	 * @param string $type
	 * @param string $encoding
	 *
	 * @return \DOMDocument
	 */
	public function load($content, $type = self::TYPE_HTML, $encoding = 'utf-8')
	{
		if (filter_var($content, FILTER_VALIDATE_URL) === false)
			throw new InvalidArgumentException(sprintf('First argument for %s:%s must be url only. Given %s.', __CLASS__, __METHOD__, $content));

		return $this->fileLoader->load($content, $type, $encoding);
	}
}