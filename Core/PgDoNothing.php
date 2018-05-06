<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class PgDoNothing implements DoNothing {
	private $clause;
	private $parameters;

	public function __construct(Clause $clause, array $parameters) {
		$this->clause = $clause;
		$this->parameters = $parameters;
	}

	public function returning(array $columns, array $parameters = []): Returning {
		return new Returning($this, $columns, $this->parameters()->bind($parameters)->binds());
	}

	public function sql(): string {
		return sprintf('%s DO NOTHING', $this->clause->sql());
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}