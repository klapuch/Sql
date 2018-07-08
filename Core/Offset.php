<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Offset extends Statement {
	public function limit(int $limit): Limit;
}