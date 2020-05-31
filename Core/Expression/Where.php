<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

use Klapuch\Sql\NamedParameter;

final class Where implements Expression {
	/** @var string */
	private $column;

	/** @var mixed */
	private $value;

	/** @var \Klapuch\Sql\NamedParameter */
	private $parameter;

	/**
	 * @param string $column
	 * @param mixed $value
	 */
	public function __construct(string $column, $value) {
		$this->column = $column;
		$this->value = $value;
		$this->parameter = new NamedParameter($column);
	}

	public function sql(): string {
		return sprintf('%s = :%s', $this->column, $this->parameter);
	}

	public function parameters(): array {
		return [(string) $this->parameter => $this->value];
	}
}
