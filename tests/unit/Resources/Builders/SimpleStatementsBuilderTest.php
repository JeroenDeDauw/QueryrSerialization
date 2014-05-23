<?php

namespace Tests\Queryr\Resources\Builders;

use DataValues\StringValue;
use Queryr\Resources\Builders\SimpleItemBuilder;
use Queryr\Resources\Builders\SimpleStatementsBuilder;
use Queryr\Resources\SimpleItem;
use Queryr\Resources\SimpleStatement;
use Wikibase\DataModel\Claim\ClaimList;
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
 * @covers Queryr\Resources\Builders\SimpleStatementsBuilder
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleStatementsBuilderTest extends \PHPUnit_Framework_TestCase {



	private function addClaims( Item $item ) {
		$claim = new Statement( new PropertyValueSnak( 42, new StringValue( 'kittens' ) ) );
		$claim->setGuid( 'first guid' );

		$item->addClaim( $claim );

		$claim = new Statement( new PropertyNoValueSnak( 23 ) );
		$claim->setGuid( 'second guid' );

		$item->addClaim( $claim );
	}

	public function testSerializationForDe() {
		$statement = new Statement( new PropertyValueSnak( 42, new StringValue( 'kittens' ) ) );
		$statement->setGuid( 'first guid' );

		$simpleItem = ( new SimpleStatementsBuilder( 'en' ) )->buildFromStatements( new ClaimList( [
			$statement
		] ) );

		$expected = [
			SimpleStatement::newInstance()
				->withProperty( 'P42' )->withType( 'string' )->withValues( [ new StringValue( 'kittens' ) ] )
		];

		$this->assertEquals( $expected, $simpleItem );
	}

}
