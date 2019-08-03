<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

final class Expressions implements Expression {
	/** @var string */
	private $separator;

	/** @var \Klapuch\Sql\Expression\Expression[] */
	private $expressions;

	public function __construct(string $separator, Expression ...$expressions) {
		$this->separator = $separator;
		$this->expressions = $expressions;
	}

	public function sql(): string {
		return trim(implode(
			$this->separator,
			array_filter(
				array_map(static function (Expression $expression): string {
					return $expression->sql();
				}, $this->expressions),
			),
		));
	}

	/**
	 * @return mixed[]
	 */
	public function parameters(): array {
		return array_merge(
			[],
			...array_map(static function (Expression $expression): array {
				   return $expression->parameters();
			}, $this->expressions),
		);
	}
}
