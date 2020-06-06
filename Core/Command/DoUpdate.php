<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Command;

final class DoUpdate implements Command {
	public function sql(): string {
		return 'DO UPDATE';
	}

	public function parameters(): array {
		return [];
	}
}
