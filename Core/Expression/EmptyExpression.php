<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

final class EmptyExpression implements Expression {
	public function sql(): string {
		return '';
	}

	/**
	 * @return mixed[]
	 */
	public function parameters(): array {
		return [];
	}
}
