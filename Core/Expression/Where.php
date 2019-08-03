<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

final class Where implements Expression {
	/** @var string */
	private $column;

	/** @var mixed */
	private $value;

	/**
	 * @param string $column
	 * @param mixed $value
	 */
	public function __construct(string $column, $value) {
		$this->column = $column;
		$this->value = $value;
	}

	public function sql(): string {
		return sprintf('%1$s = :%1$s', $this->column);
	}

	public function parameters(): array {
		return [$this->column => $this->value];
	}
}
