<?php

namespace Queryr\Resources;

use DataValues\DataValue;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleStatement {

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