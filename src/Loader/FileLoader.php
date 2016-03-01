<?php
namespace DOMNavigator\Loader;

class FileLoader implements LoaderInterface
{
	/**
	 * Load document by file path.
	 *
	 * @param string $content
	 * @param string $encoding
	 * @param int $type
	 *
	 * @return \DOMDocument
	 */
	public function load($content, $encoding = 'utf-8', $type = self::TYPE_HTML)
	{
		$document = new \DOMDocument('1.0', $encoding);
		$document->load($content);

		return $document;
	}
}