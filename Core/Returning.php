<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class Returning implements Clause {
	private $clause;
	private $columns;
	private $parameters;

	public function __construct(Clause $clause, array $columns, array $parameters) {
		$this->clause = $clause;
		$this->columns = $columns;
		$this->parameters = $parameters;
	}

	public function sql(): string {
		return sprintf(
			'%s RETURNING %s',
			$this->clause->sql(),
			implode(', ', $this->columns)
		);
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}