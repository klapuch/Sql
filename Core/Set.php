<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Set extends Statement {
	public function where(string $comparison, array $parameters = []): Where;
}
