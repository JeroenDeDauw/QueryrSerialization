<?php

namespace Queryr\Serialization;

use Queryr\Resources\ItemList;
use Queryr\Resources\ItemListElement;
use Serializers\Exceptions\UnsupportedObjectException;
use Serializers\Serializer;

/**
 * @access private
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ItemListSerializer implements Serializer {

	public function serialize( $object ) {
		if ( !( $object instanceof ItemList ) ) {
			throw new UnsupportedObjectException( $object, 'Can only serialize instances of ItemList' );
		}

		return $this->serializeList( $object );
	}

	private function serializeList( ItemList $list ) {
		$serialization = [];

		foreach ( $list->getElements() as $element ) {
			$serialization[] = $this->serializeElement( $element );
		}

		return $serialization;
	}

	private function serializeElement( ItemListElement $element ) {
		return [
			'id' => $element->getItemId()->getSerialization(),
			'updated_at' => $element->getLastUpdateTime(),
			'url' => $element->getApiUrl(),
			'wikidata_url' => $element->getWikidataUrl(),
		];
	}

}
