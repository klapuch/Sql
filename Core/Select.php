<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Select extends Statement {
	public function from(array $tables, array $parameters = []): From;
}
