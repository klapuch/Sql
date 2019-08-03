<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

final class Update implements Clause {
	/** @var string */
	private $table;

	public function __construct(string $table) {
		$this->table = $table;
	}

	public function sql(): string {
		return sprintf('UPDATE %s', $this->table);
	}

	public function parameters(): array {
		return [];
	}
}
