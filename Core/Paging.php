<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Paging extends Clause {
	public function limit(int $limit): Limit;
	public function offset(int $offset): Offset;
}