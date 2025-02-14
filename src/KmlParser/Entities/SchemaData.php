<?php
declare(strict_types=1);

namespace KamelPhp\KmlParser\Entities;

use KamelPhp\XmlElement\Element;

class SchemaData extends Entity
{

	public function getSchemaUrl(): string
	{
		return $this->element->getAttribute('schemaUrl');
	}

	/**
	 * @return SimpleData[]
	 */
	public function getSimpleData(): array
	{
		return array_map(function (Element $element) {
			return new SimpleData($element);
		}, $this->element->getChildren('SimpleData'));
	}
}
