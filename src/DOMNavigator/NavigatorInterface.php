<?php
namespace DOMNavigator;

interface NavigatorInterface
{
	/**
	 * Load html document by url, file path or string content
	 *
	 * @param string $content
	 * @param string $encoding
	 *
	 * @return $this
	 */
	public function loadHTML($content, $encoding = 'utf-8');

	/**
	 * Load xml document by url, file path or string content
	 *
	 * @param string $content
	 * @param string $encoding
	 *
	 * @return $this
	 */
	public function loadXML($content, $encoding = 'utf-8');

	/**
	 * Navigate in loaded document
	 *
	 * @param $query
	 * @param \DOMElement|null $context
	 *
	 * @return \DOMNodeList
	 */
	public function navigate($query, \DOMElement $context = null);
}