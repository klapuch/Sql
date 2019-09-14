<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

use Klapuch\Sql;

final class Set implements Expression {
	/** @var mixed[] */
	private $assigning;

	public function __construct(array $assigning) {
		$this->assigning = $assigning;
	}

	public function sql(): string {
		return implode(
			', ',
			array_map(static function (string $column, $value): string {
				return $value instanceof Sql\Expression\Expression
					? sprintf('%s = %s', $column, $value->sql())
					: sprintf('%s = :%s', $column, new Sql\PreparedColumn($column));
			}, array_keys($this->assigning), $this->assigning),
		);
	}

	public function parameters(): array {
		$values = [];
		foreach ($this->assigning as $column => $value) {
			$values += $value instanceof Sql\Expression\Expression
				? $value->parameters()
				: [(string) new Sql\PreparedColumn($column) => $value];
		}
		return $values;
	}
}
