<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiOffset implements Offset {
	private $clause;
	private $offset;
	private $parameters;

	public function __construct(Clause $clause, int $offset, array $parameters) {
		$this->clause = $clause;
		$this->offset = $offset;
		$this->parameters = $parameters;
	}

	public function limit(int $limit): Limit {
		return new AnsiLimit($this, $limit, $this->parameters()->binds());
	}

	public function sql(): string {
		if ($this->offset === 0)
			return $this->clause->sql();
		return sprintf('%s OFFSET %s', $this->clause->sql(), $this->offset);
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}