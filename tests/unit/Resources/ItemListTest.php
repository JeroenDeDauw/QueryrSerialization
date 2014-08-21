<?php

namespace Tests\Queryr\Resources\Builders;

use Queryr\Resources\ItemList;
use Queryr\Resources\ItemListElement;
use Wikibase\DataModel\Entity\ItemId;

/**
 * @covers Queryr\Resources\ItemList
 * @covers Queryr\Resources\ItemListElement
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ItemListTest extends \PHPUnit_Framework_TestCase {

	public function testSetAndGetElements() {
		$items = [
			new ItemListElement(
				new ItemId( 'Q1' ),
				'2014-08-16T19:52:04Z',
				'https://www.wikidata.org/entity/Q1',
				'http://api.queryr.com/properties/Q1'
			),
			new ItemListElement(
				new ItemId( 'Q2' ),
				'2014-05-30T16:31:27Z',
				'https://www.wikidata.org/entity/Q2',
				'http://api.queryr.com/properties/Q2'
			)
		];

		$list = new ItemList( $items );
		$this->assertSame( $items, $list->getElements() );


	}

	public function testElement() {
		$item = new ItemListElement(
			new ItemId( 'Q1' ),
			'2014-08-16T19:52:04Z',
			'https://www.wikidata.org/entity/Q1',
			'http://api.queryr.com/properties/Q1'
		);

		$this->assertEquals( new ItemId( 'Q1' ), $item->getItemId() );
		$this->assertEquals( '2014-08-16T19:52:04Z', $item->getLastUpdateTime() );
		$this->assertEquals( 'https://www.wikidata.org/entity/Q1', $item->getWikidataUrl() );
		$this->assertEquals( 'http://api.queryr.com/properties/Q1', $item->getApiUrl() );
	}

}
