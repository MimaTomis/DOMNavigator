<?php
namespace DOMNavigator\Loader;

use DOMNavigator\Exception\InvalidArgumentException;
use DOMNavigator\Exception\LogicException;

class FileLoader implements LoaderInterface
{
	/**
	 * Load document by file path.
	 *
	 * @param string $content
	 * @param string $type
	 * @param string $encoding
	 *
	 * @return \DOMDocument
	 */
	public function load($content, $type = self::TYPE_HTML, $encoding = 'utf-8')
	{
		if (!is_file($content))
			throw new InvalidArgumentException(sprintf('File %s not found. First argument for %s:%s must be path to existing file', $content, __CLASS__, __METHOD__));

		if (!is_readable($content))
			throw new LogicException(sprintf('File %s is not readable', $content));

		$mimeType = mime_content_type($content);

		if (preg_match('/(\w+)$/i', $mimeType, $matches)) {
			$mimeType = mb_strtolower($matches[1], $encoding);

			if ($type != $mimeType)
				throw new LogicException(sprintf('Given file %s is not %s', $content, $type));
		}

		$document = new \DOMDocument('1.0', $encoding);

		if ($type == self::TYPE_XML)
			$document->load($content);
		else
			$document->loadHTMLFile($content);

		return $document;
	}
}