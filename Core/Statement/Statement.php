<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Statement;

use Klapuch\Sql\Clause\Clause;

abstract class Statement {
	/**
	 * @return mixed[]
	 */
	abstract protected function orders(): array;

	final public function sql(): string {
		return implode(
			' ',
			array_filter(
				array_map(
					static function(Clause $clause): string {
						return $clause->sql();
					},
					$this->orders(),
				),
			),
		);
	}

	final public function parameters(): array {
		return array_merge(
			[],
			...array_filter(
				array_map(
					static function(Clause $clause): array {
						return $clause->parameters();
					},
					$this->orders(),
				),
			),
		);
	}
}
