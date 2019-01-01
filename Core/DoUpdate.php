<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface DoUpdate extends Statement {
	public function returning(array $columns, array $parameters = []): Returning;
}
