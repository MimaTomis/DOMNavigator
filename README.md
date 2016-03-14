# PHP DOMNavigator

[![Build Status](https://travis-ci.org/MimaTomis/DOMNavigator.svg)](https://travis-ci.org/MimaTomis/DOMNavigator)

## About library

The library is a wrapper for the implementation of DOM in php.
Designed for easy loading html document, parse it.
It allows you to implement your own algorithm search elements.

## Documentation

 - [Installation](#installation)
 - [Use Navigator](#use-navigator)
 - [Create custom Finder](#create-custom-finder)
 - [Create custom Loader](#create-custom-loader)
 - [Use CompositeLoader](#use-compositeloader)

### Installation

Run command:

    composer require mima/dom-navigator

Add dependency on your composer.json:

```json
{
    "require": {
        "mima/dom-navigator": "@stable"
    }
}
```

### Use Navigator

For beginning usage navigator need create an instance of `DOMNavigator\Navigator` class:

```php
use DOMNavigator\Navigator;
use DOMNavigator\Loader\StringLoader;
use DOMNavigator\Finder\XPathFinder;

$loader = new StringLoader();
$finder = new XPathFinder();

$navigator = new Navigator($loader, $finder);
```

Before search in document need load document:

```php
// For load HTML document call:
$navigator->loadHTML($htmlContent);

// or call next method for load XML document:
$navigator->loadXML($xmlContent);
```

When you call method `loadHTML` or `loadXML`, navigator try to load `DOMDocument` with help `DOMNavigator\Loader\StringLoader` (in this example).
After loading you may use navigate method for search elements in document.

```php
// return \DOMNodeList with list of found elements
$addressNodes = $navigator->navigate("//div[@id='address']");
```

Navigate method always return \DOMNodeList. It is possible to search in the context of an element:

```php
// $addresNodes is a list of element from previous example
$cityNodes = $navigator->navigate("*[@id='city']", $addressNodes->item(0));
```

If you want find out number of found elements, follow to this example:

```php
if ($cityNodes->length > 0) {
    ...
}
```

### Create custom Finder

All finders need implement interface `DOMNavigator\Finder\FinderInterface`.

### Create custom Loader

All loaders need implement `DOMNavigator\Finder\LoaderInterface`.

### Use CompositeLoader

If you are not sure of the source through the document, you can use CompositeLoader:

```php
use DOMNavigator\Loader\CompositeLoader;
use DOMNavigator\Loader\URLLoader;
use DOMNavigator\Loader\FileLoader;
use DOMNavigator\Loader\StringLoader;


$stringLoader = new StringLoader();
$urlLoader = new URLLoader($stringLoader);
$fileLoader = new FileLoader();

// set loaders with construct
$compositeLoader = new CompositeLoader([$stringLoader, $urlLoader]);

// set loader with method
$compositeLoader->addLoader($fileLoader);
```

The next step is assigning the loader in the navigator:

```php
// as first argument in constructor
$navigator = new Navigator($compositeLoader, $finder);

// or using a special method
$navigator->setLoader($compositeLoader);
```