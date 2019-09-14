<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

use Klapuch\Sql\PreparedColumn;

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
		return sprintf('%s = :%s', $this->column, new PreparedColumn($this->column));
	}

	public function parameters(): array {
		return [(string) new PreparedColumn($this->column) => $this->value];
	}
}
