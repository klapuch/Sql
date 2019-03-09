<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class In implements Statement {
	/** @var string */
	private $column;

	/** @var mixed[] */
	private $parameters;

	public function __construct(string $column, array $parameters = []) {
		$this->column = $column;
		$this->parameters = $parameters;
	}

	public function sql(): string {
		return sprintf(
			'%s IN (%s)',
			$this->column,
			self::in($this->parameters)
		);
	}

	public function parameters(): Parameters {
		return new UniqueParameters(
			self::named($this->parameters)
				? self::renames($this->parameters)
				: $this->parameters
		);
	}

	private static function in(array $parameters): string {
		if (!self::named($parameters)) {
			return implode(', ', array_fill(0, count($parameters), '?'));
		}
		return implode(', ', array_keys(self::renames($parameters)));
	}

	private static function renames(array $parameters): array {
		[$group, $parameters] = [array_key_first($parameters), current($parameters)];
		return (array) array_combine(
			array_map(static function ($name) use ($group): string {
				return sprintf(':%s_%s', $group, $name);
			}, array_keys($parameters)),
			$parameters
		);
	}

	private static function named(array $parameters): bool {
		return is_array(current($parameters));
	}
}
