<?php

namespace Queryr\Serialization;

use Serializers\Serializer;

/**
 * @access public
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SerializerFactory {

	/**
	 * @return Serializer
	 */
	public function newSimpleItemSerializer() {
		return new SimpleItemSerializer(
			new SimpleItemFoundationSerializer(),
			new SimpleStatementSerializer()
		);
	}

	/**
	 * @param string[] $propertyMap Maps property id (string) to stable property name
	 * @return Serializer
	 */
	public function newStableItemSerializer( array $propertyMap ) {
		return new StableItemSerializer(
			new SimpleItemFoundationSerializer(),
			new SimpleStatementSerializer(),
			$propertyMap
		);
	}

	/**
	 * @return Serializer
	 */
	public function newPropertyListSerializer() {
		return new PropertyListSerializer();
	}

}
