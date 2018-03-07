<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiFrom implements From {
	private $clause;
	private $tables;
	private $parameters;

	public function __construct(Clause $clause, array $tables, array $parameters) {
		$this->clause = $clause;
		$this->tables = $tables;
		$this->parameters = $parameters;
	}

	public function where(string $comparison, array $parameters = []): Where {
		return new AnsiWhere($this, $comparison, $this->parameters()->bind($parameters)->binds());
	}

	public function join(string $type, string $table, string $condition, array $parameters = []): Join {
		return new CustomJoin($this, $type, $table, $condition, $this->parameters()->bind($parameters)->binds());
	}

	public function groupBy(array $columns): GroupBy {
		return new AnsiGroupBy($this, $columns, $this->parameters()->binds());
	}

	public function having(string $condition, array $parameters = []): Having {
		return new AnsiHaving($this, $condition, $this->parameters()->bind($parameters)->binds());
	}

	public function orderBy(array $orders): OrderBy {
		return new AnsiOrderBy($this, $orders, $this->parameters()->binds());
	}

	public function limit(int $limit, array $parameters = []): Limit {
		return new AnsiLimit($this, $limit, $this->parameters()->bind($parameters)->binds());
	}

	public function offset(int $offset, array $parameters = []): Offset {
		return new AnsiOffset($this, $offset, $this->parameters()->bind($parameters)->binds());
	}

	public function sql(): string {
		return sprintf('%s FROM %s', $this->clause->sql(), implode(', ', $this->tables));
	}

	public function parameters(): Parameters {
		return new Parameters($this->parameters);
	}
}