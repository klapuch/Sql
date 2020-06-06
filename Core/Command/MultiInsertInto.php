<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Command;

final class MultiInsertInto implements Command {
	/** @var string */
	private $table;

	/** @var mixed[] */
	private $values;

	public function __construct(string $table, array $values) {
		$this->table = $table;
		$this->values = $values;
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
					self::suitedNames($this->values),
				),
			),
		);
	}

	private static function suitedNames(array $values): array {
		$rows = count($values[array_key_first($values)]);
		$names = self::names(array_keys($values), $rows);
		return array_map(null, ...array_chunk($names, count($values) === count($names) ? 1 : $rows));
	}

	private static function names(array $columns, int $parameters): array {
		$names = [];
		foreach ($columns as $column)
			for ($position = 1; $position <= $parameters; ++$position)
				$names[] = sprintf(':%s__%d', $column, $position);
		return $names;
	}

	public function parameters(): array {
		return (array) array_combine(
			str_replace(':', '', array_merge(...self::suitedNames($this->values))),
			array_merge(...array_map(null, ...array_values($this->values))),
		);
	}
}
