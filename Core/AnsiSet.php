<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiSet implements Set {
	private $clause;
	private $values;
	private $parameters;

	public function __construct(Clause $clause, array $values, array $parameters = []) {
		$this->clause = $clause;
		$this->values = $values;
		$this->parameters = $parameters;
	}

	public function where(string $comparison, array $parameters = []): Where {
		return new AnsiWhere($this, $comparison, $this->parameters()->bind($parameters)->binds());
	}

	public function sql(): string {
		return sprintf(
			'%s SET %s',
			$this->clause->sql(),
			implode(
				', ',
				array_map(
					function(string $column, string $order): string {
						return sprintf('%s = %s', $column, $order);
					},
					array_keys($this->values),
					$this->values
				)
			)
		);
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}