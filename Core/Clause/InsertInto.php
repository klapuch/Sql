<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

use Klapuch\Sql;

final class InsertInto implements Clause {
	/** @var string */
	private $table;

	/** @var \Klapuch\Sql\NamedParameters */
	private $parameters;

	public function __construct(string $table, array $values) {
		$this->table = $table;
		$this->parameters = new Sql\NamedParameters($values);
	}

	public function sql(): string {
		$names = $this->parameters->names();
		return sprintf(
			'INSERT INTO %s (%s) VALUES (%s)',
			$this->table,
			implode(', ', array_keys($names)),
			implode(', ', $names),
		);
	}

	public function parameters(): array {
		return $this->parameters->values();
	}
}
