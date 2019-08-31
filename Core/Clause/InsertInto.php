<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

use Klapuch\Sql\Expression\Expression;
use Klapuch\Sql;

final class InsertInto implements Clause {
	/** @var string */
	private $table;

	/** @var mixed[] */
	private $values;

	/** @var Sql\PreparedStatement */
	private $preparedStatement;

	public function __construct(string $table, array $values) {
		$this->preparedStatement = new Sql\PreparedStatement($values);
		$this->table = $table;
		$this->values = $values;
	}

	public function sql(): string {
		return sprintf(
			'INSERT INTO %s (%s) VALUES (%s)',
			$this->table,
			implode(', ', array_keys($this->values)),
			implode(', ', $this->preparedStatement->sql()),
		);
	}

	public function parameters(): array {
		return $this->preparedStatement->parameters();
	}
}
