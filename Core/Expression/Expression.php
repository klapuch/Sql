<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

interface Expression {
	public function sql(): string;

	/**
	 * @return mixed[]
	 */
	public function parameters(): array;
}
