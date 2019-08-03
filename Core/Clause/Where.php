<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

use Klapuch\Sql\Expression\Expression;
use Klapuch\Sql\Expression\Expressions;

final class Where implements Clause {
	/** @var \Klapuch\Sql\Clause\Clause */
	private $clause;

	public function __construct(string $operator, Expression ...$expressions) {
		$this->clause = new CustomClause('WHERE', new Expressions(sprintf(' %s ', $operator), ...$expressions));
	}

	public function sql(): string {
		return $this->clause->sql();
	}

	public function parameters(): array {
		return $this->clause->parameters();
	}
}
