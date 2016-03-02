<?php
namespace DOMNavigator\Loader;

interface LoaderInterface
{
	/**
	 * Type of HTML for loaded content
	 */
	const TYPE_HTML = 'html';
	/**
	 * Type of XML for loaded content
	 */
	const TYPE_XML = 'xml';

	/**
	 * Load document by path.
	 *
	 * @param string $content
	 * @param string $type
	 * @param string $encoding
	 *
	 * @return \DOMDocument
	 */
	public function load($content, $type = self::TYPE_HTML, $encoding = 'utf-8');
}