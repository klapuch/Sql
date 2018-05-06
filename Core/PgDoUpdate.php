<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class PgDoUpdate implements DoUpdate {
	private $clause;
	private $values;
	private $parameters;

	public function __construct(Clause $clause, array $values, array $parameters) {
		$this->clause = $clause;
		$this->values = $values;
		$this->parameters = $parameters;
	}

	public function returning(array $columns, array $parameters = []): Returning {
		return new Returning($this, $columns, $this->parameters()->bind($parameters)->binds());
	}

	public function sql(): string {
		return (new AnsiSet(
			new class ($this->clause) implements Clause {
				private $clause;

				public function __construct(Clause $clause) {
					$this->clause = $clause;
				}

				public function sql(): string {
					return sprintf('%s DO UPDATE', $this->clause->sql());
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