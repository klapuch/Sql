<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Command;

final class RawInsertInto implements Command {
	/** @var string */
	private $table;

	/** @var mixed[] */
	private $values;

	/** @var mixed[] */
	private $parameters;

	public function __construct(string $table, array $values, array $parameters = []) {
		$this->table = $table;
		$this->values = $values;
		$this->parameters = $parameters;
	}

	public function sql(): string {
		return sprintf(
			'INSERT INTO %s (%s) VALUES (%s)',
			$this->table,
			implode(', ', array_keys($this->values)),
			implode(', ', $this->values),
		);
	}

	public function parameters(): array {
		return $this->parameters;
	}
}
