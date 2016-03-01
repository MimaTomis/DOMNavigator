<?php
namespace DOMNavigator\Finder;

interface QueryInterface
{
	public function addCondition($string);

	public function setContext(\DOMNode $node);

	public function getCondition();
}