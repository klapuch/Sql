<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface DoNothing extends Statement {
	public function returning(array $columns, array $parameters = []): Returning;
}
