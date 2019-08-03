<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

final class LeftJoin implements Clause {
	/** @var string */
	private $table;

	/** @var string */
	private $condition;

	public function __construct(string $table, string $condition) {
		$this->table = $table;
		$this->condition = $condition;
	}

	public function sql(): string {
		return sprintf('LEFT JOIN %s ON %s', $this->table, $this->condition);
	}

	public function parameters(): array {
		return [];
	}
}
