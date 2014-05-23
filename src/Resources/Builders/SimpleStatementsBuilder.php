<?php

namespace Queryr\Resources\Builders;

use DataValues\DataValue;
use DataValues\StringValue;
use Queryr\Resources\SimpleStatement;
use Traversable;
use Wikibase\DataModel\Claim\ClaimList;
use Wikibase\DataModel\Claim\Claims;
use Wikibase\DataModel\Claim\Statement;
use Wikibase\DataModel\Entity\EntityIdValue;
use Wikibase\DataModel\Entity\Item;
use Wikibase\DataModel\Entity\PropertyId;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertySomeValueSnak;
use Wikibase\DataModel\Snak\PropertyValueSnak;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleStatementsBuilder {

	private $languageCode;

	public function __construct( $languageCode ) {
		$this->languageCode = $languageCode;
	}

	/**
	 * @param ClaimList $statements
	 *
	 * @return array
	 */
	public function buildFromStatements( ClaimList $statements ) {
		$simpleStatements = [];

		foreach ( $statements->getPropertyIds() as $propertyId ) {
			$simpleStatement = new SimpleStatement();

			$statementValues = $this->getStatementValuesWithPropertyId( $statements, $propertyId );

			if ( !empty( $statementValues ) ) {
				$simpleStatement->values = $statementValues;
				$simpleStatement->valueType = $statementValues[0]->getType();
				$simpleStatement->propertyName = $propertyId->getSerialization();

				$simpleStatements[] = $simpleStatement;
			}
		}

		return $simpleStatements;
	}

	/**
	 * @param ClaimList $statements
	 * @param PropertyId $propertyId
	 *
	 * @return DataValue[]
	 */
	private function getStatementValuesWithPropertyId( ClaimList $statements, PropertyId $propertyId ) {
		$statementIndex = new Claims( $statements->toArray() );

		$statementValues = [];

		/**
		 * @var Statement $statement
		 */
		foreach ( $statementIndex->getClaimsForProperty( $propertyId )->getBestClaims() as $statement ) {
			$snak = $statement->getMainSnak();

			if ( $snak instanceof PropertyValueSnak ) {
				$statementValues[] = $this->handle( $snak );
			}
		}

		return $statementValues;
	}

	private function handle( PropertyValueSnak $snak ) {
		$value = $snak->getDataValue();

		if ( $value instanceof EntityIdValue ) {
			return new StringValue( $value->getEntityId()->getSerialization() );
		}

		return $value;
	}

}