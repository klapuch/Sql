<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class PreparedUpdate implements Update {
	private $origin;

	public function __construct(Update $origin) {
		$this->origin = $origin;
	}

	public function set(array $values, array $parameters = []): Set {
		return new AnsiSet(
			$this,
			array_combine(array_keys($values), array_fill(0, count($values), '?')),
			$this->parameters()->bind(array_values($values))->binds()
		);
	}

	public function sql(): string {
		return $this->origin->sql();
	}

	public function parameters(): Parameters {
		return $this->origin->parameters();
	}
}