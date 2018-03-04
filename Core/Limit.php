<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Limit extends Clause {
	public function offset(int $offset): Offset;
}