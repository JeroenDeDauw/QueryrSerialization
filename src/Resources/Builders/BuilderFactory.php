<?php

namespace Queryr\Resources\Builders;

use Queryr\TermStore\LabelLookup;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class BuilderFactory {

	public function newSimpleItemBuilder( $languageCode, LabelLookup $labelLookup ) {
		return new SimpleItemBuilder(
			$languageCode,
			new SimpleStatementsBuilder( $languageCode, $labelLookup )
		);
	}

}