<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

use Klapuch\Sql\NamedParameters;

final class WhereIn implements Expression {
	/** @var string */
	private $column;

	/** @var \Klapuch\Sql\NamedParameters */
	private $parameters;

	public function __construct(string $column, array $parameters) {
		$this->column = $column;
		$this->parameters = new NamedParameters($parameters, $column);
	}

	public function sql(): string {
		return sprintf(
			'%s IN (%s)',
			$this->column,
			implode(', ', $this->parameters->names()),
		);
	}

	public function parameters(): array {
		return $this->parameters->values();
	}
}
