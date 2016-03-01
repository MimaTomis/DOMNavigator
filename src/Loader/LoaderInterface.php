<?php
namespace DOMNavigator\Loader;

interface LoaderInterface
{
	/**
	 * Type of HTML for loaded content
	 */
	const TYPE_HTML = 1;
	/**
	 * Type of XML for loaded content
	 */
	const TYPE_XML = 2;

	/**
	 * Load document by path.
	 *
	 * @param string $content
	 * @param string $encoding
	 * @param int $type
	 *
	 * @return \DOMDocument
	 */
	public function load($content, $encoding = 'utf-8', $type = self::TYPE_HTML);
}