<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class PgDoNothing implements DoNothing {
	/** @var \Klapuch\Sql\Statement */
	private $statement;

	/** @var mixed[] */
	private $parameters;

	public function __construct(Statement $statement, array $parameters) {
		$this->statement = $statement;
		$this->parameters = $parameters;
	}

	public function returning(array $columns, array $parameters = []): Returning {
		return new Returning($this, $columns, $this->parameters()->bind($parameters)->binds());
	}

	public function sql(): string {
		return sprintf('%s DO NOTHING', $this->statement->sql());
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}
