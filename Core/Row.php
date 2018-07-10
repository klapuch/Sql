<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class Row implements Type {
	private $types;

	public function __construct(Type ...$types) {
		$this->types = $types;
	}

	public function expression(): string {
		return sprintf(
			'ROW(%s)',
			implode(
				', ',
				array_map(
					function(Type $type): string {
						return $type->expression();
					},
					$this->types
				)
			)
		);
	}
}