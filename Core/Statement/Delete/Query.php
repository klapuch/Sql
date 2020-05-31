<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Statement\Delete;

use Klapuch\Sql;
use Klapuch\Sql\Clause;
use Klapuch\Sql\Expression\EmptyExpression;
use Klapuch\Sql\Expression\Expression;
use Klapuch\Sql\Statement\Statement;

final class Query extends Statement {
	/** @var array<mixed[]> */
	private $sql;

	public function __construct(array $sql = []) {
		$this->sql = $sql
			+ array_fill_keys(['andWhere', 'orWhere'], [new EmptyExpression()])
			+ ['returning' => new Sql\Clause\EmptyClause()]
			+ ['from' => new EmptyExpression()];
	}

	public function from(string $table): self {
		return new self(['from' => [new Sql\Expression\From([$table])]] + $this->sql);
	}

	public function where(Expression $where): self {
		return new self(['andWhere' => array_merge($this->sql['andWhere'], [$where])] + $this->sql);
	}

	public function orWhere(Expression $where): self {
		return new self(['orWhere' => array_merge($this->sql['orWhere'], [$where])] + $this->sql);
	}

	public function returning(Clause\Clause $returning): self {
		return new self(['returning' => $returning] + $this->sql);
	}

	protected function orders(): array {
		return [
			new class implements Clause\Clause {
				public function sql(): string {
					return 'DELETE';
				}

				public function parameters(): array {
					return [];
				}
			},
			new Clause\From(...$this->sql['from']),
			new Clause\MultiWhere(['AND' => $this->sql['andWhere'], 'OR' => $this->sql['orWhere']]),
			$this->sql['returning'],
		];
	}
}
