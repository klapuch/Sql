<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

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
			implode(', ', array_map(static function (string $column): string {
				return sprintf(':%s', $column);
			}, array_keys($this->values))),
		);
	}

	public function parameters(): array {
		return $this->values;
	}
}
