<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

interface Clause {
	public function sql(): string;

	/**
	 * @return mixed[]
	 */
	public function parameters(): array;
}
