<?php
namespace DOMNavigator\Loader;

class StringLoader implements LoaderInterface
{
	/**
	 * Load document by string content.
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

		if ($type == self::TYPE_XML) {
			$content = $this->normalizeXMLString($content, $encoding);
			$document->loadXML($content);
		} else
			$document->loadHTML($content);

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