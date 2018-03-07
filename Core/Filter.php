<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Filter extends Clause {
	public function where(string $condition, array $parameters = []): Where;
}