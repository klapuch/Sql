<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Sort extends Clause {
	public function orderBy(array $orders): OrderBy;
}