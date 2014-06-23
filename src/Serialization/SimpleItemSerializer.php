<?php

namespace Queryr\Serialization;

use Queryr\Resources\SimpleItem;
use Queryr\Resources\SimpleStatement;
use Serializers\Exceptions\UnsupportedObjectException;
use Serializers\Serializer;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleItemSerializer implements Serializer {

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

		$serialization['data'] = $this->getDataSection();

		return $serialization;
	}

	private function getDataSection() {
		$data = [];

		foreach ( $this->item->statements as $simpleStatement ) {
			$data[$simpleStatement->propertyName] = $this->getPropertyValue( $simpleStatement );
		}

		return $data;
	}

	private function getPropertyValue( SimpleStatement $simpleStatement ) {
		$propertyValue = [
			'value' => $simpleStatement->values[0]->getArrayValue(),
			'type' => $simpleStatement->valueType
		];

		if ( count( $simpleStatement->values ) > 1 ) {
			$propertyValue['values'] = [];

			foreach ( $simpleStatement->values as $value ) {
				$propertyValue['values'][] = $value->getArrayValue();
			}
		}

		return $propertyValue;
	}

}