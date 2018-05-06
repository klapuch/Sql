<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiUpdate implements Update {
	private $table;

	public function __construct(string $table) {
		$this->table = $table;
	}

	public function set(array $values, array $parameters = []): Set {
		return new AnsiSet($this, $values, $this->parameters()->bind($parameters)->binds());
	}

	public function sql(): string {
		return sprintf('UPDATE %s', $this->table);
	}

	public function parameters(): Parameters {
		return new UniqueParameters();
	}
}