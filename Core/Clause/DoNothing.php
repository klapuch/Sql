<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

final class DoNothing implements Clause {
	public function sql(): string {
		return 'DO NOTHING';
	}

	public function parameters(): array {
		return [];
	}
}
