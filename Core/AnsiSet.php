<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiSet implements Set {
	/** @var \Klapuch\Sql\Statement */
	private $statement;

	/** @var mixed[] */
	private $values;

	/** @var mixed[] */
	private $parameters;

	public function __construct(Statement $statement, array $values, array $parameters = []) {
		$this->statement = $statement;
		$this->values = $values;
		$this->parameters = $parameters;
	}

	public function where(string $comparison, array $parameters = []): Where {
		return new AnsiWhere($this, $comparison, $this->parameters()->bind($parameters)->binds());
	}

	public function sql(): string {
		return sprintf(
			'%s SET %s',
			$this->statement->sql(),
			implode(
				', ',
				array_map(
					static function(string $column, string $order): string {
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
