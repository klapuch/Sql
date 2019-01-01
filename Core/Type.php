<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Type {
	public function expression(): string;
}
