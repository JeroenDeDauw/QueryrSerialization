<?php

namespace Tests\Queryr\Resources\Builders;

use DataValues\StringValue;
use Queryr\Resources\Builders\SimpleItemBuilder;
use Queryr\Resources\SimpleItem;
use Queryr\Resources\SimpleStatement;
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
 * @covers Queryr\Resources\Builders\SimpleItemBuilder
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleItemBuilderTest extends \PHPUnit_Framework_TestCase {

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
		$simpleItem = ( new SimpleItemBuilder( 'de' ) )->buildFromItem( $this->newItem() );

		$expected = new SimpleItem();
		$expected->ids = [
			'wikidata' => 'Q1337',
			'en.wikipedia' => 'En Page',
			'de.wikipedia' => 'De Page',
		];

		$expected->label = 'bar';
		$expected->description = 'de description';
		$expected->aliases = [ 'first de alias', 'second de alias' ];

		$expected->statements = [
			SimpleStatement::newInstance()
				->withProperty( 'P42' )->withType( 'string' )->withValues( [ new StringValue( 'kittens' ) ] )
		];

		$this->assertEquals( $expected, $simpleItem );
	}

	public function testSerializationForEn() {
		$simpleItem = ( new SimpleItemBuilder( 'en' ) )->buildFromItem( $this->newItem() );

		$expected = new SimpleItem();
		$expected->ids = [
			'wikidata' => 'Q1337',
			'en.wikipedia' => 'En Page',
		];

		$expected->label = 'foo';
		$expected->aliases = [ 'first en alias', 'second en alias' ];

		$expected->statements = [
			SimpleStatement::newInstance()
				->withProperty( 'P42' )->withType( 'string' )->withValues( [ new StringValue( 'kittens' ) ] )
		];

		$this->assertEquals( $expected, $simpleItem );
	}

	public function testSerializationForNl() {
		$simpleItem = ( new SimpleItemBuilder( 'nl' ) )->buildFromItem( $this->newItem() );

		$expected = new SimpleItem();
		$expected->ids = [
			'wikidata' => 'Q1337',
			'en.wikipedia' => 'En Page',
		];

		$expected->label = 'baz';

		$expected->statements = [
			SimpleStatement::newInstance()
				->withProperty( 'P42' )->withType( 'string' )->withValues( [ new StringValue( 'kittens' ) ] )
		];

		$this->assertEquals( $expected, $simpleItem );
	}

}
