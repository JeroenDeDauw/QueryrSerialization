<?php

namespace Queryr\Resources;

use DataValues\DataValue;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleStatement {

	public static function newInstance() {
		return new self();
	}

	public function withProperty( $propertyName ) {
		$this->propertyName = $propertyName;
		return $this;
	}

	public function withType( $type ) {
		$this->valueType = $type;
		return $this;
	}

	public function withValues( array $values ) {
		$this->values = $values;
		return $this;
	}

	/**
	 * @var string
	 */
	public $propertyName;

	/**
	 * @var string
	 */
	public $valueType;

	/**
	 * @var DataValue[]
	 */
	public $values = [];

}