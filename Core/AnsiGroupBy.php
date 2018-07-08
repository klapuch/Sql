<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiGroupBy implements GroupBy {
	private $statement;
	private $columns;
	private $parameters;

	public function __construct(Statement $statement, array $columns, array $parameters) {
		$this->statement = $statement;
		$this->columns = $columns;
		$this->parameters = $parameters;
	}

	public function having(string $condition, array $parameters = []): Having {
		return new AnsiHaving($this, $condition, $this->parameters()->bind($parameters)->binds());
	}

	public function orderBy(array $orders): OrderBy {
		return new AnsiOrderBy($this, $orders, $this->parameters()->binds());
	}

	public function limit(int $limit): Limit {
		return new AnsiLimit($this, $limit, $this->parameters()->binds());
	}

	public function offset(int $offset): Offset {
		return new AnsiOffset($this, $offset, $this->parameters()->binds());
	}

	public function sql(): string {
		return sprintf('%s GROUP BY %s', $this->statement->sql(), implode(', ', $this->columns));
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}