<?php
namespace DOMNavigator\Loader;

use DOMNavigator\Exception\InvalidArgumentException;
use DOMNavigator\Exception\UnexpectedValueException;

class URLLoader implements LoaderInterface
{
	/**
	 * @var StringLoader
	 */
	private $stringLoader;

	/**
	 * Aggregate with FileLoader for delegate load method
	 *
	 * @param StringLoader $stringLoader
	 */
	public function __construct(StringLoader $stringLoader)
	{
		$this->stringLoader = $stringLoader;
	}

	/**
	 * Load document by url.
	 *
	 * @param string $content
	 * @param string $type
	 * @param string $encoding
	 *
	 * @return \DOMDocument
	 */
	public function load($content, $type = self::TYPE_HTML, $encoding = 'utf-8')
	{
		if (filter_var($content, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) === false)
			throw new InvalidArgumentException(sprintf('First argument for %s:%s must be url only. Given %s.', __CLASS__, __METHOD__, $content));

		$content = $this->loadContentFromUrl($content);

		return $this->stringLoader->load($content, $type, $encoding);
	}

	/**
	 * @param string $url
	 * @return string
	 */
	public function loadContentFromUrl($url)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

		$result = curl_exec($ch);
		$status = curl_getinfo($ch);

		curl_close($ch);

		if ($status['http_code'] != 200)
 			throw new UnexpectedValueException(sprintf('Content from url %s can not be loaded', $url));

		return $result;
	}
}