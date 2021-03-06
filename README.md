This library, as a standalone, has been **abandoned** after it got merged into https://github.com/JeroenDeDauw/QueryrAPI

# QueryR Serialization

[![Build Status](https://secure.travis-ci.org/JeroenDeDauw/QueryrSerialization.png?branch=master)](http://travis-ci.org/JeroenDeDauw/QueryrSerialization)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JeroenDeDauw/QueryrSerialization/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/JeroenDeDauw/QueryrSerialization/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/JeroenDeDauw/QueryrSerialization/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/JeroenDeDauw/QueryrSerialization/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/queryr/serialization/version.png)](https://packagist.org/packages/queryr/serialization)
[![Download count](https://poser.pugx.org/queryr/serialization/d/total.png)](https://packagist.org/packages/queryr/serialization)

Serializers for QueryR resources.

## System dependencies

* PHP 5.5 or later (PHP 7 and HHVM are supported)

## Running the tests

For tests only

    composer test

For style checks only

	composer cs

For a full CI run

	composer ci

## Release notes

### Version 1.0.1 (2017-05-16)

* Added support for Wikibase DataModel 7.x, 6.x and 5.x

### Version 1.0.0 (2015-11-04)

* Added support for Wikibase DataModel 4.x and 3.x
* Changed minimum Wikibase DataModel version to 3.0
* Added ci command that runs PHPUnit, PHPCS, PHPMD and covers tags validation
* Added TravisCI and ScrutinizerCI integration

### Version 0.8.2 (2014-12-14)

* Wikipedia IDs changed format from `en.wikipedia` to `en_wikipedia`
* Wikibase DataModel 1.x is no longer supported

### Version 0.8.1 (2014-10-21)

* Made installable together with Wikibase DataModel 2.x

### Version 0.8 (2014-09-12)

* Replaced the constructor of `ItemListElement` with setters
* Added "wikipedia page url" and "label" to `ItemListElement`, both optional strings

### Version 0.7 (2014-08-30)

* Added `ItemType` resource
* Added `SerializerFactory::newItemTypeSerializer`

### Version 0.6 (2014-08-21)

* Added `ItemList` resource
* Added `SerializerFactory::newItemListSerializer`
* Added `newSimplePropertyBuilder` to the `BuilderFactory`

### Version 0.5 (2014-08-20)

* Added `SimpleProperty` resource
* Added `SimplePropertyBuilder`
* Added `SimplePropertySerializer`

### Version 0.4 (2014-08-18)

* Added `PropertyList` resource
* Added `SerializerFactory::newPropertyListSerializer`

### Version 0.3 (2014-08-05)

* All serializers are now package private
* Added `SerializerFactory` which is package public

### Version 0.2 (2014-08-05)

* Added `StableItemSerializer`

### Version 0.1.1 (2014-06-23)

* Fixed issue in `BuilderFactory`

### Version 0.1 (2014-06-23)

Initial release with support for serialization of items in QueryR format.
