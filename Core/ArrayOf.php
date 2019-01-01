<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class ArrayOf implements Type {
	/** @var string */
	private $type;

	/** @var \Klapuch\Sql\Type[] */
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
					static function(Type $type): string {
						return $type->expression();
					},
					$this->types
				)
			),
			$this->type
		);
	}
}
