<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class ArrayOf implements Type {
	private $types;

	public function __construct(Type ...$types) {
		$this->types = $types;
	}

	public function sql(): string {
		return sprintf(
			'ARRAY[%s]',
			implode(
				', ',
				array_map(
					function(Type $type): string {
						return $type->sql();
					},
					$this->types
				)
			)
		);
	}

	public function parameters(): Parameters {
		return new UniqueParameters(
			...array_merge(
				array_map(
					function(Type $type): array {
							return $type->parameters()->binds();
					},
					$this->types
				)
			)
		);
	}
}