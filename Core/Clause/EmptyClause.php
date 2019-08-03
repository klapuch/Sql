<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

final class EmptyClause implements Clause {
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
