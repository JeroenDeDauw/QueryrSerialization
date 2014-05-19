<?php

namespace Queryr\Serialization\DataModel;

use Serializers\Exceptions\UnsupportedObjectException;
use Serializers\Serializer;
use Wikibase\DataModel\Entity\Item;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleItemSerializer implements Serializer {

	public function serialize( $object ) {
		if ( !( $object instanceof Item ) ) {
			throw new UnsupportedObjectException( $object, 'Can only serialize instances of Item' );
		}

		return $this->serializeItem( $object );
	}

	private function serializeItem( Item $item ) {

	}

}