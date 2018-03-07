<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiOrderBy implements OrderBy {
	private $clause;
	private $orders;
	private $parameters;

	public function __construct(Clause $clause, array $orders, array $parameters) {
		$this->clause = $clause;
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
		if (empty($this->orders))
			return $this->clause->sql();
		return sprintf(
			'%s ORDER BY %s',
			$this->clause->sql(),
			implode(
				', ',
				array_map(
					function(string $column, string $order): string {
						return sprintf('%s %s', $column, $order);
					},
					array_keys($this->orders),
					$this->orders
				)
			)
		);
	}

	public function parameters(): Parameters {
		return new Parameters($this->parameters);
	}
}