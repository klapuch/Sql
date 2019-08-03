<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

use Klapuch\Sql\Statement\Statement;

final class Exists implements Expression {
	/** @var \Klapuch\Sql\Statement\Statement */
	private $statement;

	public function __construct(Statement $statement) {
		$this->statement = $statement;
	}

	public function sql(): string {
		return sprintf('EXISTS(%s)', $this->statement->sql());
	}

	public function parameters(): array {
		return $this->statement->parameters();
	}
}
