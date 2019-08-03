<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

use Klapuch\Sql;

final class From implements Expression {
	/** @var string[] */
	private $tables;

	public function __construct(array $tables) {
		$this->tables = $tables;
	}

	public function sql(): string {
		return (new Sql\Aliases($this->tables))->sql();
	}

	public function parameters(): array {
		return [];
	}
}
