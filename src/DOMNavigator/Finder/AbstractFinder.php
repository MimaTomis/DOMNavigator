<?php
namespace DOMNavigator\Finder;

abstract class AbstractFinder implements FinderInterface
{
	/**
	 * @var \DOMDocument
	 */
	protected $document;

	/**
	 * Set document, where finder search elements
	 *
	 * @param \DOMDocument $document
	 */
	public function setDocument(\DOMDocument $document)
	{
		$this->document = $document;
	}
}