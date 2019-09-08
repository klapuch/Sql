<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

use Klapuch\Sql;

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
				return $value instanceof Sql\Expression\Expression
					? $value->sql()
					: sprintf(':%s', $column);
			}, array_keys($this->values), $this->values)),
		);
	}

	public function parameters(): array {
		$values = [];
		foreach ($this->values as $column => $value) {
			$values += $value instanceof Sql\Expression\Expression
				? $value->parameters()
				: [$column => $value];
		}
		return $values;
	}
}
