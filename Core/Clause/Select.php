<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

use Klapuch\Sql\Expression\Expression;
use Klapuch\Sql\Expression\Expressions;

final class Select implements Clause {
	private const SEPARATOR = ', ';

	/** @var \Klapuch\Sql\Clause\Clause */
	private $clause;

	public function __construct(Expression ...$expressions) {
		$this->clause = new CustomClause('SELECT', new Expressions(self::SEPARATOR, ...$expressions));
	}

	public function sql(): string {
		return $this->clause->sql();
	}

	public function parameters(): array {
		return $this->clause->parameters();
	}
}
