<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiHaving implements Having {
	/** @var \Klapuch\Sql\Statement */
	private $statement;

	/** @var string */
	private $condition;

	/** @var mixed[] */
	private $parameters;

	public function __construct(Statement $statement, string $condition, array $parameters) {
		$this->statement = $statement;
		$this->condition = $condition;
		$this->parameters = $parameters;
	}

	public function orderBy(array $orders): OrderBy {
		return new AnsiOrderBy($this, $orders, $this->parameters);
	}

	public function limit(int $limit): Limit {
		return new AnsiLimit($this, $limit, $this->parameters()->binds());
	}

	public function offset(int $offset): Offset {
		return new AnsiOffset($this, $offset, $this->parameters()->binds());
	}

	public function sql(): string {
		return sprintf('%s HAVING %s', $this->statement->sql(), $this->condition);
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}
