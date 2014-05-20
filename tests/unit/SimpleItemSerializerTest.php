<?php

namespace Tests\Queryr\Serialization\DataModel;

use DataValues\StringValue;
use Queryr\Serialization\DataModel\SimpleItemSerializer;
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
 * @covers Queryr\Serialization\DataModel\SimpleItemSerializer
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

		$fingerprint->setLabel( new Term( 'en', 'foo' ) );
		$fingerprint->setLabel( new Term( 'de', 'bar' ) );
		$fingerprint->setLabel( new Term( 'nl', 'baz' ) );

		$fingerprint->setDescription( new Term( 'de', 'de description' ) );

		$fingerprint->setAliasGroup( new AliasGroup( 'en', [ 'first en alias', 'second en alias' ] ) );
		$fingerprint->setAliasGroup( new AliasGroup( 'de', [ 'first de alias', 'second de alias' ] ) );

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

	public function testSerializationForDe() {
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

				'P23' => [
					'type' => 'novalue'
				],
			]
		];

		$this->assertEquals( $expected, $serialized );
	}

	public function testSerializationForEn() {
		$serializer = new SimpleItemSerializer( 'en' );

		$item = $this->newItem();

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
					'type' => 'string'
				],

				'P23' => [
					'type' => 'novalue'
				],
			]
		];

		$this->assertEquals( $expected, $serialized );
	}

	public function testSerializationForNl() {
		$serializer = new SimpleItemSerializer( 'nl' );

		$item = $this->newItem();

		$serialized = $serializer->serialize( $item );

		$expected = [
			'id' => [
				'wikidata' => 'Q1337',
				'en.wikipedia' => 'En Page',
			],

			'label' => 'baz',

			'data' => [
				'P42' => [
					'value' => 'kittens',
					'type' => 'string'
				],

				'P23' => [
					'type' => 'novalue'
				],
			]
		];

		$this->assertEquals( $expected, $serialized );
	}

}
