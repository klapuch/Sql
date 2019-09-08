<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

final class PgArray implements Expression {
	private const IDENTIFIER = 'pg_array';

	/** @var mixed[] */
	private $values;

	/** @var string */
	private $type;

	public function __construct(array $values, string $type) {
		$this->values = $values;
		$this->type = strtolower($type);
	}

	public function sql(): string {
		return sprintf('ARRAY[%s]::%s[]', implode(', ', $this->names($this->values, $this->type)), $this->type);
	}

	public function parameters(): array {
		return (array) array_combine(
			array_keys($this->names($this->values, $this->type)),
			$this->values,
		);
	}

	private function names(array $values, string $type): array {
		$names = [];
		for ($position = 1; $position <= count($values); ++$position) {
			$name = sprintf('%s__%s__%d__%d', self::IDENTIFIER, $type, spl_object_id($this), $position);
			$names[$name] = sprintf(':%s', $name);
		}
		return $names;
	}
}
