<?php

namespace Queryr\Serialization;

use Queryr\Resources\SimpleItem;
use Serializers\Exceptions\UnsupportedObjectException;
use Serializers\Serializer;

/**
 * @access private
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleItemFoundationSerializer implements Serializer {

	/**
	 * @var SimpleItem
	 */
	private $item;

	public function serialize( $object ) {
		if ( !( $object instanceof SimpleItem ) ) {
			throw new UnsupportedObjectException( $object, 'Can only serialize instances of SimpleItem' );
		}

		$this->item = $object;

		return $this->serializeItem();
	}

	private function serializeItem() {
		$serialization = [ 'id' => $this->item->ids ];

		if ( $this->item->label !== '' ) {
			$serialization['label'] = $this->item->label;
		}

		if ( $this->item->description !== '' ) {
			$serialization['description'] = $this->item->description;
		}

		if ( !empty( $this->item->aliases ) ) {
			$serialization['aliases'] = $this->item->aliases;
		}

		return $serialization;
	}

}