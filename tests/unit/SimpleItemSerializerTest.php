<?php

namespace Tests\Queryr\Serialization\DataModel;

use Queryr\Serialization\DataModel\SimpleItemSerializer;
use Serializers\Serializer;

/**
 * @covers Queryr\Serialization\DataModel\SimpleItemSerializer
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleItemSerializerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Serializer
	 */
	private $serializer;

	public function setUp() {
		$this->serializer = new SimpleItemSerializer();
	}

	public function testGivenNonItem_exceptionIsThrown() {
		$this->setExpectedException( 'Serializers\Exceptions\UnsupportedObjectException' );
		$this->serializer->serialize( null );
	}

}
