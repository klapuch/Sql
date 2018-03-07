<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiGroupBy implements GroupBy {
	private $clause;
	private $columns;
	private $parameters;

	public function __construct(Clause $clause, array $columns, array $parameters) {
		$this->clause = $clause;
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
		return sprintf('%s GROUP BY %s', $this->clause->sql(), implode(', ', $this->columns));
	}

	public function parameters(): Parameters {
		return new Parameters($this->parameters);
	}
}