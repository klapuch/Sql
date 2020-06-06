<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Command;

final class DoNothing implements Command {
	public function sql(): string {
		return 'DO NOTHING';
	}

	public function parameters(): array {
		return [];
	}
}
