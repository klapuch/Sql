<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Command;

interface Command {
	public function sql(): string;

	/**
	 * @return mixed[]
	 */
	public function parameters(): array;
}
