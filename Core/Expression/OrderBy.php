<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

final class OrderBy implements Expression {
	/** @var string[] */
	private $orders;

	/** @var mixed[] */
	private $parameters;

	public function __construct(array $orders, array $parameters = []) {
		$this->orders = $orders;
		$this->parameters = $parameters;
	}

	public function sql(): string {
		return implode(
			', ',
			array_map(
				static function($column, string $order): string {
					return is_int($column)
						? sprintf('%s ASC', $order)
						: sprintf('%s %s', $column, strtoupper($order));
				},
				array_keys($this->orders),
				$this->orders,
			),
		);
	}

	public function parameters(): array {
		return $this->parameters;
	}
}
