<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class ArrayOf implements Type {
	private $type;
	private $types;

	public function __construct(string $type, Type ...$types) {
		$this->type = $type;
		$this->types = $types;
	}

	public function expression(): string {
		return sprintf(
			'ARRAY[%s]::%s',
			implode(
				', ',
				array_map(
					function(Type $type): string {
						return $type->expression();
					},
					$this->types
				)
			),
			$this->type
		);
	}
}