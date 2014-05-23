<?php

namespace Tests\Queryr\Resources\Builders;

use DataValues\StringValue;
use Queryr\Resources\Builders\SimpleStatementsBuilder;
use Queryr\Resources\SimpleStatement;
use Wikibase\DataModel\Claim\ClaimList;
use Wikibase\DataModel\Claim\Statement;
use Wikibase\DataModel\Snak\PropertyValueSnak;

/**
 * @covers Queryr\Resources\Builders\SimpleStatementsBuilder
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleStatementsBuilderTest extends \PHPUnit_Framework_TestCase {

	public function testBuildFromSingleStatementWithPropertyValueSnak() {
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
