<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface OrderBy extends Statement {
	public function limit(int $limit): Limit;

	public function offset(int $offset): Offset;
}
