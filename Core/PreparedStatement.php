<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

use Klapuch\Sql\Expression\Expression;

final class PreparedStatement {
	/** @var mixed[] */
	private $parameters;

	public function __construct(array $parameters) {
		$this->parameters = $parameters;
	}

	public function sql(): array {
		return array_reduce(
			array_keys($this->parameters),
			function (array $parameters, string $column): array {
				$parameter = $this->parameters[$column];
				if ($parameter instanceof Expression) {
					return $parameters += [$column => self::sqlNames($column, $parameter->sql())];
				}
				return $parameters += [$column => sprintf(':%s', $column)];
			},
			[],
		);
	}

	/**
	 * @return mixed[]
	 */
	public function parameters(): array {
		return array_reduce(
			array_keys($this->parameters),
			function (array $parameters, string $column): array {
				$value = $this->parameters[$column];
				if ($value instanceof Expression) {
					return $parameters += self::parameterNames($column, $value->parameters());
				}
				return $parameters += [$column => $value];
			},
			[],
		);
	}

	private static function sqlNames(string $column, string $sql): string {
		return preg_replace_callback('~\?~', static function () use ($column): string {
			static $position = 0;
			return sprintf(':%s__%d', $column, ++$position);
		}, $sql);
	}

	private static function parameterNames(string $column, array $parameters): array {
		$columns = [];
		for ($position = 1; $position <= count($parameters); ++$position)
			$columns[] = sprintf('%s__%d', $column, $position);
		return (array) array_combine($columns, $parameters);
	}
}
