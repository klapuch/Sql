<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class PgDoUpdate implements DoUpdate {
	private $statement;
	private $values;
	private $parameters;

	public function __construct(Statement $statement, array $values, array $parameters) {
		$this->statement = $statement;
		$this->values = $values;
		$this->parameters = $parameters;
	}

	public function returning(array $columns, array $parameters = []): Returning {
		return new Returning($this, $columns, $this->parameters()->bind($parameters)->binds());
	}

	public function sql(): string {
		return (new AnsiSet(
			new class ($this->statement) implements Statement {
				private $statement;

				public function __construct(Statement $statement) {
					$this->statement = $statement;
				}

				public function sql(): string {
					return sprintf('%s DO UPDATE', $this->statement->sql());
				}

				public function parameters(): Parameters {
					return new UniqueParameters();
				}
			},
			$this->values,
			$this->parameters
		))->sql();
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}