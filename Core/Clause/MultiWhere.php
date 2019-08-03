<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

use Klapuch\Sql\Expression\Expressions;

final class MultiWhere implements Clause {
	/** @var \Klapuch\Sql\Clause\Clause */
	private $clause;

	public function __construct(array $where) {
		$this->clause = new CustomClause(
			'WHERE',
			new Expressions(
				sprintf(' %s ', (string) array_key_last($where)),
				new Expressions(sprintf(' %s ', 'AND'), ...$where['AND']),
				new Expressions(sprintf(' %s ', 'OR'), ...$where['OR']),
			),
		);
	}

	public function sql(): string {
		return $this->clause->sql();
	}

	public function parameters(): array {
		return $this->clause->parameters();
	}
}
