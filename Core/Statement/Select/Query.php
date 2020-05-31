<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Statement\Select;

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
			+ array_fill_keys(['from', 'andWhere', 'orWhere', 'groupBy', 'having', 'orderBy'], [new EmptyExpression()])
			+ array_fill_keys(['select', 'limit', 'offset'], new Clause\EmptyClause())
			+ ['join' => [new Clause\EmptyClause()]];
	}

	public function from(Expression $from): self {
		return new self(['from' => array_merge($this->sql['from'], [$from])] + $this->sql);
	}

	public function select(Expression $select): self {
		return new self(['select' => [$select]] + $this->sql);
	}

	public function where(Expression $where): self {
		return new self(['andWhere' => array_merge($this->sql['andWhere'], [$where])] + $this->sql);
	}

	public function orWhere(Expression $where): self {
		return new self(['orWhere' => array_merge($this->sql['orWhere'], [$where])] + $this->sql);
	}

	public function join(Clause\Clause $join): self {
		return new self(['join' => array_merge($this->sql['join'], [$join])] + $this->sql);
	}

	public function groupBy(Expression $groupBy): self {
		return new self(['groupBy' => array_merge($this->sql['groupBy'], [$groupBy])] + $this->sql);
	}

	public function having(Expression $having): self {
		return new self(['having' => array_merge($this->sql['having'], [$having])] + $this->sql);
	}

	public function orderBy(Expression $orderBy): self {
		return new self(['orderBy' => array_merge($this->sql['orderBy'], [$orderBy])] + $this->sql);
	}

	public function limit(int $limit): self {
		return new self(['limit' => new Sql\Clause\Limit($limit)] + $this->sql);
	}

	public function offset(int $offset): self {
		return new self(['offset' => new Sql\Clause\Offset($offset)] + $this->sql);
	}

	public function exists(): self {
		return new self([
			'select' => [new Sql\Expression\Exists(
				new self(
					array_fill_keys(['limit', 'offset'], new Clause\EmptyClause())
						+ ['orderBy' => [new EmptyExpression()]]
						+ ['select' => [new Sql\Expression\Select(['1'])]]
						+ $this->sql,
				),
			)],
		]);
	}

	protected function orders(): array {
		return [
			new Clause\Select(...$this->sql['select']),
			new Clause\From(...$this->sql['from']),
			new Clause\Clauses(...$this->sql['join']),
			new Clause\MultiWhere(['AND' => $this->sql['andWhere'], 'OR' => $this->sql['orWhere']]),
			new Clause\GroupBy(...$this->sql['groupBy']),
			new Clause\Having(...$this->sql['having']),
			new Clause\OrderBy(...$this->sql['orderBy']),
			$this->sql['limit'],
			$this->sql['offset'],
		];
	}
}
