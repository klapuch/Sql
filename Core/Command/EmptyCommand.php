<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Command;

final class EmptyCommand implements Command {
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
