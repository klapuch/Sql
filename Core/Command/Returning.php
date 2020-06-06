<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Command;

final class Returning implements Command {
	/** @var string[] */
	private $columns;

	/** @var mixed[] */
	private $parameters;

	public function __construct(array $columns, array $parameters = []) {
		$this->columns = $columns;
		$this->parameters = $parameters;
	}

	public function sql(): string {
		return sprintf('RETURNING %s', implode(', ', $this->columns));
	}

	public function parameters(): array {
		return $this->parameters;
	}
}
