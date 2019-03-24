<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiOrderBy implements OrderBy {
	/** @var \Klapuch\Sql\Statement */
	private $statement;

	/** @var mixed[] */
	private $orders;

	/** @var mixed[] */
	private $parameters;

	public function __construct(Statement $statement, array $orders, array $parameters) {
		$this->statement = $statement;
		$this->orders = $orders;
		$this->parameters = $parameters;
	}

	public function limit(int $limit): Limit {
		return new AnsiLimit($this, $limit, $this->parameters()->binds());
	}

	public function offset(int $offset): Offset {
		return new AnsiOffset($this, $offset, $this->parameters()->binds());
	}

	public function sql(): string {
		if ($this->orders === [])
			return $this->statement->sql();
		return sprintf(
			'%s ORDER BY %s',
			$this->statement->sql(),
			implode(
				', ',
				array_map(
					static function($column, string $order): string {
						if (is_int($column)) {
							$column = $order;
							$order = 'ASC';
						}
						return sprintf('%s %s', $column, $order);
					},
					array_keys($this->orders),
					$this->orders
				)
			)
		);
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}
