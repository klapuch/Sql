<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

final class Set implements Expression {
	/** @var mixed[] */
	private $assigning;

	public function __construct(array $assigning) {
		$this->assigning = $assigning;
	}

	public function sql(): string {
		return implode(
			', ',
			array_map(static function (string $column): string {
				return sprintf('%1$s = :%1$s', $column);
			}, array_keys($this->assigning)),
		);
	}

	public function parameters(): array {
		return $this->assigning;
	}
}
