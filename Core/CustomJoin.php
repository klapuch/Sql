<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class CustomJoin implements Join {
	private $clause;
	private $type;
	private $table;
	private $condition;
	private $parameters;

	public function __construct(Clause $clause, string $type, string $table, string $condition, array $parameters) {
		$this->clause = $clause;
		$this->type = $type;
		$this->table = $table;
		$this->condition = $condition;
		$this->parameters = $parameters;
	}

	public function join(string $type, string $table, string $condition, array $parameters = []): Join {
		return new self($this, $type, $table, $condition, $this->parameters()->bind($parameters)->binds());
	}

	public function where(string $comparison, array $parameters = []): Where {
		return new AnsiWhere($this, $comparison, $this->parameters()->bind($parameters)->binds());
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

	public function limit(int $limit): Limit {
		return new AnsiLimit($this, $limit, $this->parameters()->binds());
	}

	public function offset(int $offset): Offset {
		return new AnsiOffset($this, $offset, $this->parameters()->binds());
	}

	public function sql(): string {
		return sprintf('%s %s JOIN %s ON %s', $this->clause->sql(), $this->type, $this->table, $this->condition);
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}