<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

final class GroupBy implements Expression {
	/** @var string[] */
	private $columns;

	public function __construct(string ...$columns) {
		$this->columns = $columns;
	}

	public function sql(): string {
		return implode(', ', $this->columns);
	}

	public function parameters(): array {
		return [];
	}
}
