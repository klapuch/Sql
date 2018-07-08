<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiOffset implements Offset {
	private $statement;
	private $offset;
	private $parameters;

	public function __construct(Statement $statement, int $offset, array $parameters) {
		$this->statement = $statement;
		$this->offset = $offset;
		$this->parameters = $parameters;
	}

	public function limit(int $limit): Limit {
		return new AnsiLimit($this, $limit, $this->parameters()->binds());
	}

	public function sql(): string {
		if ($this->offset === 0)
			return $this->statement->sql();
		return sprintf('%s OFFSET %s', $this->statement->sql(), $this->offset);
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}