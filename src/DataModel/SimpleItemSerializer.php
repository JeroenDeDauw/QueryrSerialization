<?php

namespace Queryr\Serialization\DataModel;

use Serializers\Exceptions\UnsupportedObjectException;
use Serializers\Serializer;
use Wikibase\DataModel\Claim\Statement;
use Wikibase\DataModel\Entity\Item;
use Wikibase\DataModel\Snak\PropertyNoValueSnak;
use Wikibase\DataModel\Snak\PropertySomeValueSnak;
use Wikibase\DataModel\Snak\PropertyValueSnak;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SimpleItemSerializer implements Serializer {

	private $languageCode;

	/**
	 * @var Item
	 */
	private $item;

	public function __construct( $languageCode = 'en' ) {
		$this->languageCode = $languageCode;
	}

	public function serialize( $object ) {
		if ( !( $object instanceof Item ) ) {
			throw new UnsupportedObjectException( $object, 'Can only serialize instances of Item' );
		}

		$this->item = $object;
		return $this->serializeItem();
	}

	private function serializeItem() {
		$serialization = [ 'id' => $this->getIdSection() ];

		$this->addLabel( $serialization );
		$this->addDescription( $serialization );
		$this->addAliases( $serialization );

		$serialization['data'] = $this->getDataSection();

		return $serialization;
	}

	private function getIdSection() {
		$ids = [ 'wikidata' => $this->item->getId()->getSerialization() ];

		$this->addIdLinkForLanguage( $ids, 'en' );
		$this->addIdLinkForLanguage( $ids, $this->languageCode );

		return $ids;
	}

	private function addIdLinkForLanguage( array &$ids, $languageCode ) {
		$links = $this->item->getSiteLinkList();

		if ( $links->hasLinkWithSiteId( $languageCode . 'wiki' ) ) {
			$ids[$languageCode . '.wikipedia'] = $links->getBySiteId( $languageCode . 'wiki' )->getPageName();
		}
	}

	private function addLabel( &$s ) {
		if ( $this->item->getFingerprint()->getLabels()->hasTermForLanguage( $this->languageCode ) ) {
			$s['label'] = $this->item->getFingerprint()->getLabel( $this->languageCode )->getText();
		}
	}

	private function addDescription( &$s ) {
		if ( $this->item->getFingerprint()->getDescriptions()->hasTermForLanguage( $this->languageCode ) ) {
			$s['description'] = $this->item->getFingerprint()->getDescription( $this->languageCode )->getText();
		}
	}

	private function addAliases( &$s ) {
		if ( $this->item->getFingerprint()->getAliasGroups()->hasGroupForLanguage( $this->languageCode ) ) {
			$s['aliases'] = $this->item->getFingerprint()->getAliasGroup( $this->languageCode )->getAliases();
		}
	}

	private function getDataSection() {
		$data = [];

		foreach ( $this->item->getClaims() as $statement ) {
			$data[$statement->getPropertyId()->getSerialization()] = $this->getStatementSerialization( $statement );
		}

		return $data;
	}

	private function getStatementSerialization( Statement $statement ) {
		$snak = $statement->getMainSnak();

		if ( $snak instanceof PropertyValueSnak ) {
			return $snak->getDataValue()->toArray();
		}
		elseif ( $snak instanceof PropertyNoValueSnak ) {
			return [ 'type' => 'novalue' ];
		}
		elseif ( $snak instanceof PropertySomeValueSnak ) {
			return [ 'type' => 'somevalue' ];
		}

		// TODO: SerializationException
		throw new \RuntimeException( '' );
	}

}