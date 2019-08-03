<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

final class DoUpdate implements Clause {
	public function sql(): string {
		return 'DO UPDATE';
	}

	public function parameters(): array {
		return [];
	}
}
