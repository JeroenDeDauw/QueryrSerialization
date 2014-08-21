<?php

namespace Queryr\Resources;

use Wikibase\DataModel\Entity\ItemId;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ItemListElement {

	private $itemId;
	private $lastUpdate;
	private $pageUrl;
	private $apiUrl;

	/**
	 * @param ItemId $itemId
	 * @param string $lastUpdateTime
	 * @param string $pageUrl
	 * @param string $apiUrl
	 */
	public function __construct( ItemId $itemId, $lastUpdateTime, $pageUrl, $apiUrl ) {
		$this->itemId = $itemId;
		$this->lastUpdate = $lastUpdateTime;
		$this->pageUrl = $pageUrl;
		$this->apiUrl = $apiUrl;
	}

	/**
	 * @return string
	 */
	public function getApiUrl() {
		return $this->apiUrl;
	}

	/**
	 * @return string
	 */
	public function getWikidataUrl() {
		return $this->pageUrl;
	}

	/**
	 * @return ItemId
	 */
	public function getItemId() {
		return $this->itemId;
	}

	/**
	 * @return string
	 */
	public function getLastUpdateTime() {
		return $this->lastUpdate;
	}

}
