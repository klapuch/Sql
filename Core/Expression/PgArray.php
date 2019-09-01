<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

final class PgArray implements Expression {
	/** @var mixed[] */
	private $values;

	/** @var string */
	private $type;

	public function __construct(array $values, string $type) {
		$this->values = $values;
		$this->type = $type;
	}

	public function sql(): string {
		return sprintf('ARRAY[%s]::%s[]', implode(', ', array_fill(0, count($this->values), '?')), $this->type);
	}

	public function parameters(): array {
		return $this->values;
	}
}
