<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class PreparedUpdate implements Update {
	/** @var \Klapuch\Sql\Update */
	private $origin;

	public function __construct(Update $origin) {
		$this->origin = $origin;
	}

	public function set(array $values, array $parameters = []): Set {
		return new AnsiSet(
			$this,
			(array) array_combine(
				array_keys($values),
				array_map(
					static function (string $column): string {
						return sprintf(':%s', $column);
					},
					array_keys($values)
				)
			),
			$this->parameters()->bind($values)->binds()
		);
	}

	public function sql(): string {
		return $this->origin->sql();
	}

	public function parameters(): Parameters {
		return $this->origin->parameters();
	}
}
