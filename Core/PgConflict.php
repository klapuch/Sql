<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class PgConflict implements Conflict {
	private $clause;
	private $target;
	private $parameters;

	public function __construct(Clause $clause, array $target, array $parameters) {
		$this->clause = $clause;
		$this->target = $target;
		$this->parameters = $parameters;
	}

	public function doUpdate(array $values = [], array $parameters = []): DoUpdate {
		return new PgDoUpdate($this, $values, $this->parameters()->bind($parameters)->binds());
	}

	public function doNothing(): DoNothing {
		return new PgDoNothing($this, $this->parameters);
	}

	public function sql(): string {
		return sprintf(
			'%s ON CONFLICT%s',
			$this->clause->sql(),
			$this->target
				? sprintf(' (%s)', implode(', ', $this->target))
				: ''
		);
	}

	public function parameters(): Parameters {
		return new Parameters($this->parameters);
	}
}