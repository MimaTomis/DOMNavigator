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
$nodeList = $navigator->navigate('//div[@id=phone]');
```

Navigate method always return \DOMNodeList. If you want find out number of found elements, follow to this example:

```php
if ($nodeList->length > 0) {
    ...
}
```

### Create custom Finder

All Finders need implement `DOMNavigato\Finder\FinderInterface`.