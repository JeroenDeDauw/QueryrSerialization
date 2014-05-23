<?php

namespace Tests\Queryr\Serialization;

use DataValues\StringValue;
use Queryr\Serialization\SimpleItemSerializer;
use Wikibase\DataModel\Claim\Statement;
use Wikibase\DataModel\Entity\Item;
use Wikibase\DataModel\SiteLink;
use Wikibase\DataModel\SiteLinkList;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Term\AliasGroup;
use Wikibase\DataModel\Term\Fingerprint;
use Wikibase\DataModel\Term\Term;

/**
 * @covers Queryr\Serialization\SimpleItemSerializer
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleItemSerializerTest extends \PHPUnit_Framework_TestCase {

	public function testGivenNonItem_exceptionIsThrown() {
		$serializer = new SimpleItemSerializer();

		$this->setExpectedException( 'Serializers\Exceptions\UnsupportedObjectException' );
		$serializer->serialize( null );
	}

	private function newItem() {
		$item = Item::newEmpty();

		$item->setId( 1337 );

		$item->setFingerprint( $this->newFingerprint() );
		$item->setSiteLinkList( $this->newSiteLinks() );

		$this->addClaims( $item );

		return $item;
	}

	private function newFingerprint() {
		$fingerprint = Fingerprint::newEmpty();

		$fingerprint->setLabel( 'en', 'foo' );
		$fingerprint->setLabel( 'de', 'bar' );
		$fingerprint->setLabel( 'nl', 'baz' );

		$fingerprint->setDescription( 'de', 'de description' );

		$fingerprint->setAliasGroup( 'en', [ 'first en alias', 'second en alias' ] );
		$fingerprint->setAliasGroup( 'de', [ 'first de alias', 'second de alias' ] );

		return $fingerprint;
	}

	private function newSiteLinks() {
		$links = new SiteLinkList();

		$links->add( new SiteLink( 'enwiki', 'En Page' ) );
		$links->add( new SiteLink( 'dewiki', 'De Page' ) );

		return $links;
	}

	private function addClaims( Item $item ) {
		$claim = new Statement( new PropertyValueSnak( 42, new StringValue( 'kittens' ) ) );
		$claim->setGuid( 'first guid' );

		$item->addClaim( $claim );

		$claim = new Statement( new PropertyNoValueSnak( 23 ) );
		$claim->setGuid( 'second guid' );

		$item->addClaim( $claim );
	}

	public function testSerializationWithValueForOneProperty() {
		$serializer = new SimpleItemSerializer( 'de' );

		$item = $this->newItem();

		$serialized = $serializer->serialize( $item );

		$expected = [
			'id' => [
				'wikidata' => 'Q1337',
				'en.wikipedia' => 'En Page',
				'de.wikipedia' => 'De Page',
			],

			'label' => 'bar',
			'description' => 'de description',
			'aliases' => [ 'first de alias', 'second de alias' ],

			'data' => [
				'P42' => [
					'value' => 'kittens',
					'type' => 'string'
				],
			]
		];

		$this->assertEquals( $expected, $serialized );
	}

	public function testSerializationWithMultipleValuesForOneProperty() {
		$serializer = new SimpleItemSerializer( 'en' );

		$item = $this->newItem();

		$claim = new Statement( new PropertyValueSnak( 42, new StringValue( 'cats' ) ) );
		$claim->setGuid( 'third guid' );

		$item->addClaim( $claim );

		$serialized = $serializer->serialize( $item );

		$expected = [
			'id' => [
				'wikidata' => 'Q1337',
				'en.wikipedia' => 'En Page',
			],

			'label' => 'foo',
			'aliases' => [ 'first en alias', 'second en alias' ],

			'data' => [
				'P42' => [
					'value' => 'kittens',
					'values' => [ 'kittens', 'cats' ],
					'type' => 'string'
				],
			]
		];

		$this->assertEquals( $expected, $serialized );
	}

}
