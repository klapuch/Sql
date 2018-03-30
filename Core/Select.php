<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Select extends Clause {
	public function from(array $tables, array $parameters = []): From;
}