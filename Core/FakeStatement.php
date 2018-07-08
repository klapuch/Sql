<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class FakeStatement implements Statement {
	public function sql(): string {
		return '';
	}

	public function parameters(): Parameters {
		return new UniqueParameters();
	}
}