<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class AnsiSelect implements Select {
	private $columns;
	private $parameters;

	public function __construct(array $columns, array $parameters = []) {
		$this->columns = $columns;
		$this->parameters = $parameters;
	}

	public function from(array $tables, array $parameters = []): From {
		return new AnsiFrom($this, $tables, $this->parameters()->bind($parameters)->binds());
	}

	public function sql(): string {
		return sprintf('SELECT %s', implode(', ', $this->columns));
	}

	public function parameters(): Parameters {
		return new Parameters($this->parameters);
	}
}