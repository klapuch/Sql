<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Statement\Update;

use Klapuch\Sql\Clause;
use Klapuch\Sql\Expression\EmptyExpression;
use Klapuch\Sql\Expression\Expression;
use Klapuch\Sql\Statement\Statement;

final class Query extends Statement {
	/** @var array<mixed[]> */
	private $sql = [];

	public function __construct(array $sql = []) {
		$this->sql = $sql
			+ array_fill_keys(['from', 'andWhere', 'orWhere', 'set'], [new EmptyExpression()])
			+ ['returning' => new Clause\EmptyClause()];
	}

	public function update(string $table): self {
		return new self(['update' => new Clause\Update($table)] + $this->sql);
	}

	public function from(Expression $from): self {
		return new self(['from' => array_merge($this->sql['from'], [$from])] + $this->sql);
	}

	public function where(Expression $where): self {
		return new self(['andWhere' => array_merge($this->sql['andWhere'], [$where])] + $this->sql);
	}

	public function orWhere(Expression $where): self {
		return new self(['orWhere' => array_merge($this->sql['orWhere'], [$where])] + $this->sql);
	}

	public function set(Expression $set): self {
		return new self(['set' => array_merge($this->sql['set'], [$set])] + $this->sql);
	}

	public function returning(Clause\Clause $returning): self {
		return new self(['returning' => $returning] + $this->sql);
	}

	protected function orders(): array {
		return [
			$this->sql['update'],
			new Clause\Set(...$this->sql['set']),
			new Clause\From(...$this->sql['from']),
			new Clause\MultiWhere(['AND' => $this->sql['andWhere'], 'OR' => $this->sql['orWhere']]),
			$this->sql['returning'],
		];
	}
}
