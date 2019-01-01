<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiLimit implements Limit {
	/** @var \Klapuch\Sql\Statement */
	private $statement;

	/** @var int */
	private $limit;

	/** @var mixed[] */
	private $parameters;

	public function __construct(Statement $statement, int $limit, array $parameters) {
		$this->statement = $statement;
		$this->limit = $limit;
		$this->parameters = $parameters;
	}

	public function offset(int $offset): Offset {
		return new AnsiOffset($this, $offset, $this->parameters()->binds());
	}

	public function sql(): string {
		if ($this->limit === PHP_INT_MAX)
			return $this->statement->sql();
		return sprintf('%s LIMIT %s', $this->statement->sql(), $this->limit);
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}
