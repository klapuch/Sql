<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiWhere implements Where {
	private $condition;
	private $statement;
	private $parameters;

	public function __construct(Statement $statement, string $condition, array $parameters) {
		$this->condition = $condition;
		$this->statement = $statement;
		$this->parameters = $parameters;
	}

	public function where(string $condition, array $parameters = []): Where {
		return new ConjunctWhere($this, 'AND', $condition, $this->parameters()->bind($parameters)->binds());
	}

	public function orWhere(string $condition, array $parameters = []): Where {
		return new ConjunctWhere($this, 'OR', $condition, $this->parameters()->bind($parameters)->binds());
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

	public function returning(array $columns, array $parameters = []): Returning {
		return new Returning($this, $columns, $this->parameters()->bind($parameters)->binds());
	}

	public function limit(int $limit): Limit {
		return new AnsiLimit($this, $limit, $this->parameters()->binds());
	}

	public function offset(int $offset): Offset {
		return new AnsiOffset($this, $offset, $this->parameters()->binds());
	}

	public function sql(): string {
		return sprintf('%s WHERE %s', $this->statement->sql(), $this->condition);
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}