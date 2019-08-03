<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

final class RawSet implements Expression {
	/** @var string */
	private $assigning;

	/** @var mixed[] */
	private $parameters;

	public function __construct(string $assigning, array $parameters = []) {
		$this->assigning = $assigning;
		$this->parameters = $parameters;
	}

	public function sql(): string {
		return $this->assigning;
	}

	public function parameters(): array {
		return $this->parameters;
	}
}
