<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Statement\Insert;

use Klapuch\Sql\Clause;
use Klapuch\Sql\Expression\EmptyExpression;
use Klapuch\Sql\Expression\Expression;
use Klapuch\Sql\Statement\Statement;

final class Query extends Statement {
	/** @var array<mixed[]> */
	private $sql = [];

	public function __construct(array $sql = []) {
		$this->sql = $sql
			+ array_fill_keys(['insertInto', 'onConflict', 'doUpdate', 'doNothing', 'returning'], new Clause\EmptyClause())
			+ ['set' => [new EmptyExpression()]];
	}

	public function insertInto(Clause\Clause $insertInto): self {
		return new self(['insertInto' => $insertInto] + $this->sql);
	}

	public function set(Expression $set): self {
		return new self(['set' => array_merge($this->sql['set'], [$set])] + $this->sql);
	}

	public function onConflict(Clause\Clause $onConflict): self {
		return new self(['onConflict' => $onConflict] + $this->sql);
	}

	public function doUpdate(): self {
		return new self(['doUpdate' => new Clause\DoUpdate()] + $this->sql);
	}

	public function doNothing(): self {
		return new self(['doNothing' => new Clause\DoNothing()] + $this->sql);
	}

	public function returning(Clause\Clause $returning): self {
		return new self(['returning' => $returning] + $this->sql);
	}

	protected function orders(): array {
		return [
			$this->sql['insertInto'],
			$this->sql['onConflict'],
			$this->sql['doUpdate'],
			$this->sql['doNothing'],
			new Clause\Set(...$this->sql['set']),
			$this->sql['returning'],
		];
	}
}
