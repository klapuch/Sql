<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

use Klapuch\Sql\Statement\Statement;

final class PgArray implements Expression {
	/** @var mixed[] */
	private $values;

	public function __construct(array $values) {
		$this->values = $values;
	}

	public function sql(): string {
		return sprintf('ARRAY[%s]', implode(', ', array_fill(0, count($this->values), '?')));
	}

	public function parameters(): array {
		return $this->values;
	}
}
