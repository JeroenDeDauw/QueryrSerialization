<?php

namespace Queryr\Resources\Builders;

use DataValues\DataValue;
use DataValues\StringValue;
use Queryr\Resources\SimpleStatement;
use Wikibase\DataModel\Claim\ClaimList;
use Wikibase\DataModel\Claim\Claims;
use Wikibase\DataModel\Entity\EntityId;
use Wikibase\DataModel\Entity\EntityIdValue;
use Wikibase\DataModel\Entity\PropertyId;
use Wikibase\DataModel\Snak\PropertyValueSnak;
use Wikibase\DataModel\Statement\Statement;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleStatementsBuilder {

	private $languageCode;
	private $labelLookup;

	public function __construct( $languageCode, ResourceLabelLookup $labelLookup ) {
		$this->languageCode = $languageCode;
		$this->labelLookup = $labelLookup;
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
				$simpleStatement->propertyName = $this->getEntityName( $propertyId );
				$simpleStatement->propertyId = $propertyId;

				$simpleStatements[] = $simpleStatement;
			}
		}

		return $simpleStatements;
	}

	private function getEntityName( EntityId $id ) {
		$label = $this->labelLookup->getLabelByIdAndLanguage( $id, $this->languageCode );

		return $label === null ? $id->getSerialization() : $label;
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
			return new StringValue( $this->getEntityName( $value->getEntityId() ) );
		}

		return $value;
	}

}