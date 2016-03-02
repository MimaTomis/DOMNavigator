<?php
namespace DOMNavigator\Loader;

class StringLoader implements LoaderInterface
{
	/**
	 * Load document by string content.
	 *
	 * @param string $content
	 * @param string $type
	 * @param string $encoding
	 *
	 * @return \DOMDocument
	 */
	public function load($content, $type = self::TYPE_HTML, $encoding = 'utf-8')
	{
		$previousValue = libxml_use_internal_errors(TRUE);
		$document = new \DOMDocument('1.0', $encoding);

		if ($type == self::TYPE_XML) {
			$content = $this->normalizeXMLString($content, $encoding);
			$document->loadXML($content);
		} else
			$document->loadHTML($content);

		libxml_clear_errors();
		libxml_use_internal_errors($previousValue);

		return $document;
	}

	/**
	 * Normalize xml string for loading document. Add xml tag, if not set before.
	 *
	 * @param string $content
	 * @param string $encoding
	 *
	 * @return string
	 */
	protected function normalizeXMLString($content, $encoding)
	{
		return !preg_match('/^<\?xml/i', trim($content)) ? sprintf('<?xml version="1.0" encoding="%s"?>%s', $encoding, $content) : $content;
	}
}