<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class Row implements Type {
	private $values;

	public function __construct(array $values) {
		$this->values = $values;
	}

	public function sql(): string {
		return sprintf('ROW(%s)', implode(', ', $this->placeholders($this->values)));
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->values);
	}

	private function placeholders(array $values): array {
		if (array_values($values) === $values)
			return array_fill(0, count($values), '?');
		return array_map(
			function(string $column): string {
				return sprintf(':%s', $column);
			},
			array_keys($values)
		);
	}
}