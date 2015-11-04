# QueryR Serialization

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

### Version 1.0.0 (2015-11-04)

* Added support for Wikibase DataModel 4.x and 3.x
* Changed minimum Wikibase DataModel version to 3.0

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
