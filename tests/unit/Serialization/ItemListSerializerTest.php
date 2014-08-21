<?php

namespace Tests\Queryr\Serialization;

use Queryr\Resources\ItemList;
use Queryr\Resources\ItemListElement;
use Queryr\Serialization\SerializerFactory;
use Wikibase\DataModel\Entity\ItemId;

/**
 * @covers Queryr\Serialization\ItemListSerializer
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ItemListSerializerTest extends \PHPUnit_Framework_TestCase {

	public function testGivenNonItem_exceptionIsThrown() {
		$serializer = ( new SerializerFactory() )->newItemListSerializer();

		$this->setExpectedException( 'Serializers\Exceptions\UnsupportedObjectException' );
		$serializer->serialize( null );
	}

	public function testSerialize() {
		$input = new ItemList( [
			new ItemListElement(
				new ItemId( 'Q1' ),
				'2014-04-27T09:00:29Z',
				'http://www.wikidata.org/entity/Q1',
				'http://api.queryr.com/items/Q1'
			),
			new ItemListElement(
				new ItemId( 'Q2' ),
				'2011-05-08T14:34:39Z',
				'http://www.wikidata.org/entity/Q2',
				'http://api.queryr.com/items/Q2'
			)
		] );

		$expected = [
			[
				'id' => 'Q1',
				'updated_at' => '2014-04-27T09:00:29Z',
				'url' => 'http://api.queryr.com/items/Q1',
				'wikidata_url' => 'http://www.wikidata.org/entity/Q1',
			],
			[
				'id' => 'Q2',
				'updated_at' => '2011-05-08T14:34:39Z',
				'url' => 'http://api.queryr.com/items/Q2',
				'wikidata_url' => 'http://www.wikidata.org/entity/Q2',
			]
		];

		$output = ( new SerializerFactory() )->newItemListSerializer()->serialize( $input );

		$this->assertSame( $expected, $output );
	}

}
