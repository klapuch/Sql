<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiLimit implements Limit {
	private $clause;
	private $limit;
	private $parameters;

	public function __construct(Clause $clause, int $limit, array $parameters) {
		$this->clause = $clause;
		$this->limit = $limit;
		$this->parameters = $parameters;
	}

	public function offset(int $offset): Offset {
		return new AnsiOffset($this, $offset, $this->parameters()->binds());
	}

	public function sql(): string {
		return sprintf('%s LIMIT %s', $this->clause->sql(), $this->limit);
	}

	public function parameters(): Parameters {
		return new Parameters($this->parameters);
	}
}