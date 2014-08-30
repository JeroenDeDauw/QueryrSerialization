# QueryR Serialization

Serializers for QueryR resources.

## Release notes

#### Version 0.7 (2014-08-30)

* Added `ItemType` resource
* Added `SerializerFactory::newItemTypeSerializer`

#### Version 0.6 (2014-08-21)

* Added `ItemList` resource
* Added `SerializerFactory::newItemListSerializer`
* Added `newSimplePropertyBuilder` to the `BuilderFactory`

#### Version 0.5 (2014-08-20)

* Added `SimpleProperty` resource
* Added `SimplePropertyBuilder`
* Added `SimplePropertySerializer`

#### Version 0.4 (2014-08-18)

* Added `PropertyList` resource
* Added `SerializerFactory::newPropertyListSerializer`

#### Version 0.3 (2014-08-05)

* All serializers are now package private
* Added `SerializerFactory` which is package public

#### Version 0.2 (2014-08-05)

* Added `StableItemSerializer`

#### Version 0.1.1 (2014-06-23)

* Fixed issue in `BuilderFactory`

#### Version 0.1 (2014-06-23)

Initial release with support for serialization of items in QueryR format.
