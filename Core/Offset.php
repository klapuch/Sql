<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Offset extends Clause {
	public function limit(int $limit): Limit;
}