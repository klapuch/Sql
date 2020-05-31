<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

use Klapuch\Sql\Expression\Expression;

final class NamedParameters {
	/** @var mixed[] */
	private $parameters;

	/** @var string|null */
	private $column;

	public function __construct(array $parameters, ?string $column = null) {
		$this->parameters = $parameters;
		$this->column = $column;
	}

	/**
	 * @return string[]
	 */
	public function names(): array {
		$names = [];
		if ($this->column === null) {
			foreach ($this->parameters as $name => $value) {
				$names[$name] = $value instanceof Expression
					? $value->sql()
					: sprintf(':%s', new NamedParameter($name));
			}
		} else {
			$column = (string) new NamedParameter($this->column);
			for ($i = 1; $i <= count($this->parameters); ++$i) {
				$names[] = sprintf(':%s__%d', $column, $i);
			}
		}
		return $names;
	}

	public function values(): array {
		$values = [];
		if ($this->column === null) {
			foreach ($this->parameters as $column => $value) {
				$values += $value instanceof Expression
					? $value->parameters()
					: [(string) new NamedParameter($column) => $value];
			}
		} else {
			$values = array_combine(
				array_map(static function (string $name): string {
					return substr($name, 1);
				}, $this->names()),
				$this->parameters,
			);
		}
		assert(is_array($values));
		return $values;
	}
}
