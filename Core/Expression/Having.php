<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

final class Having implements Expression {
	/** @var string */
	private $condition;

	/** @var mixed[] */
	private $parameters;

	public function __construct(string $condition, array $parameters = []) {
		$this->condition = $condition;
		$this->parameters = $parameters;
	}

	public function and(string $condition, array $parameters = []): self {
		return new self(
			implode(' ', [$this->condition, 'AND', $condition]),
			array_merge($this->parameters, $parameters)
		);
	}

	public function or(string $condition, array $parameters = []): self {
		return new self(
			implode(' ', [$this->condition, 'OR', $condition]),
			array_merge($this->parameters, $parameters)
		);
	}

	public function sql(): string {
		return sprintf('(%s)', $this->condition);
	}

	public function parameters(): array {
		return $this->parameters;
	}
}
