<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Statement;

use Klapuch\Sql\Command\Command;

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
					static function(Command $command): string {
						return $command->sql();
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
					static function(Command $command): array {
						return $command->parameters();
					},
					$this->orders(),
				),
			),
		);
	}
}
