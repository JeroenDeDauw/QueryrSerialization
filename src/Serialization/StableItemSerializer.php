<?php

namespace Queryr\Serialization;

use Queryr\Resources\SimpleItem;
use Serializers\Exceptions\UnsupportedObjectException;
use Serializers\Serializer;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class StableItemSerializer implements Serializer {

	/**
	 * @var Serializer
	 */
	private $foundationalSerializer;

	/**
	 * @var SimpleItem
	 */
	private $item;

	public function __construct() {
		$this->foundationalSerializer = new SimpleItemFoundationSerializer();
	}

	public function serialize( $object ) {
		if ( !( $object instanceof SimpleItem ) ) {
			throw new UnsupportedObjectException( $object, 'Can only serialize instances of SimpleItem' );
		}

		$this->item = $object;

		return $this->serializeItem();
	}

	private function serializeItem() {
		$serialization = $this->foundationalSerializer->serialize( $this->item );

		$serialization['data'] = $this->getDataSection();

		return $serialization;
	}

	private function getDataSection() {
		$data = [];

		foreach ( $this->item->statements as $simpleStatement ) {

		}

		return $data;
	}

}
