<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

use Klapuch\Sql\Expression\Expression;
use Klapuch\Sql\Expression\NamedParameters;

final class InsertInto implements Clause {
	/** @var string */
	private $table;

	/** @var mixed[] */
	private $values;

	public function __construct(string $table, array $values) {
		$this->table = $table;
		$this->values = $values;
	}

	public function sql(): string {
		return sprintf(
			'INSERT INTO %s (%s) VALUES (%s)',
			$this->table,
			implode(', ', array_keys($this->values)),
			implode(', ', array_map(static function (string $column, $value): string {
				if ($value instanceof Expression) {
					return (new NamedParameters($value, $column))->sql();
				}
				return sprintf(':%s', $column);
			}, array_keys($this->values), $this->values)),
		);
	}

	public function parameters(): array {
		return array_reduce(
			array_keys($this->values),
			function (array $parameters, string $column): array {
				$value = $this->values[$column];
				if ($value instanceof Expression) {
					return $parameters += (new NamedParameters($value, $column))->parameters();
				}
				return $parameters += [$column => $value];
			},
			[],
		);
	}
}
