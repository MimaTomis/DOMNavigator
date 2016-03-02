<?php
namespace DOMNavigator\Loader;

use DOMNavigator\Exception\DOMNavigatorException;
use DOMNavigator\Exception\LogicException;

class CompositeLoader implements LoaderInterface
{
	/**
	 * List of loaders
	 *
	 * @var LoaderInterface[]
	 */
	protected $loaders = [];

	public function __construct(array $loaders = [])
	{
		if (!empty($loaders)) {
			foreach ($loaders as $loader)
				$this->addLoader($loader);
		}
	}

	/**
	 * Add loader to list
	 *
	 * @param LoaderInterface $loader
	 */
	public function addLoader(LoaderInterface $loader)
	{
		$this->loaders[] = $loader;
	}

	/**
	 * Load document by path.
	 *
	 * @param string $content
	 * @param string $type
	 *
	 * @param string $encoding
	 * @return \DOMDocument
	 * @throws \Exception
	 */
	public function load($content, $type = self::TYPE_HTML, $encoding = 'utf-8')
	{
		if (empty($this->loaders))
			throw new LogicException('Not set any loaders');

		foreach ($this->loaders as $loader) {
			try {
				if ($document = $loader->load($content, $type, $encoding))
					return $document;
			} catch (\Exception $e) {
				if (!($e instanceof DOMNavigatorException))
					throw $e;
			}
		}

		return null;
	}
}