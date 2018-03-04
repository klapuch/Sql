<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Set extends Clause {
	public function where(string $comparison, array $parameters = []): Where;
}