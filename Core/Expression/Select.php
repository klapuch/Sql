<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

use Klapuch\Sql;

final class Select implements Expression {
	/** @var string[] */
	private $columns;

	/** @var mixed[] */
	private $parameters;

	public function __construct(array $columns, array $parameters = []) {
		$this->columns = $columns;
		$this->parameters = $parameters;
	}

	public function sql(): string {
		return (string) new Sql\Aliases($this->columns);
	}

	public function parameters(): array {
		return $this->parameters;
	}
}
