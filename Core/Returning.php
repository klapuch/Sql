<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class Returning implements Statement {
	/** @var \Klapuch\Sql\Statement */
	private $statement;

	/** @var mixed[] */
	private $columns;

	/** @var mixed[] */
	private $parameters;

	public function __construct(Statement $statement, array $columns, array $parameters) {
		$this->statement = $statement;
		$this->columns = $columns;
		$this->parameters = $parameters;
	}

	public function sql(): string {
		return sprintf(
			'%s RETURNING %s',
			$this->statement->sql(),
			implode(', ', $this->columns)
		);
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}
