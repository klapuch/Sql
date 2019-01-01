<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class PgMultiInsertInto implements InsertInto {
	/** @var string */
	private $table;

	/** @var mixed[] */
	private $values;

	/** @var mixed[] */
	private $parameters;

	public function __construct(string $table, array $values, array $parameters = []) {
		$this->table = $table;
		$this->values = $values;
		$this->parameters = $parameters;
	}

	public function returning(array $columns, array $parameters = []): Returning {
		return new Returning($this, $columns, $this->parameters()->bind($parameters)->binds());
	}

	public function onConflict(array $target = [], array $parameters = []): Conflict {
		return new PgConflict($this, $target, $this->parameters()->binds());
	}

	public function sql(): string {
		return sprintf(
			'INSERT INTO %s (%s) VALUES %s',
			$this->table,
			implode(', ', array_keys($this->values)),
			implode(
				', ',
				array_map(
					static function(array $row): string {
						return sprintf('(%s)', implode(', ', $row));
					},
					array_map(null, ...array_values($this->values))
				)
			)
		);
	}

	public function parameters(): Parameters {
		return new UniqueParameters($this->parameters);
	}
}
