<?php
namespace DOMNavigator\Loader;

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
	 * @param string $encoding
	 * @param int $type
	 *
	 * @return \DOMDocument
	 */
	public function load($content, $encoding = 'utf-8', $type = self::TYPE_HTML)
	{
		if (!empty($this->loaders)) {
			foreach ($this->loaders as $loader)
				if ($document = $loader->load($content, $encoding, $type))
					return $document;
		}

		return null;
	}
}