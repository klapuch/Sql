<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

use Klapuch\Sql\PreparedColumn;

final class WhereIn implements Expression {
	/** @var string */
	private $column;

	/** @var mixed[] */
	private $parameters;

	public function __construct(string $column, array $parameters) {
		$this->column = $column;
		$this->parameters = $parameters;
	}

	public function sql(): string {
		return sprintf(
			'%s IN (%s)',
			$this->column,
			implode(', ', self::names($this->column, count($this->parameters))),
		);
	}

	private static function names(string $column, int $parameters): array {
		$names = [];
		$column = new PreparedColumn($column);
		for ($i = 1; $i <= $parameters; ++$i)
			$names[sprintf('%s__%d', $column, $i)] = sprintf(':%s__%d', $column, $i);
		return $names;
	}

	public function parameters(): array {
		return (array) array_combine(
			array_keys(self::names($this->column, count($this->parameters))),
			$this->parameters,
		);
	}
}
