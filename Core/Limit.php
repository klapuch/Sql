<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Limit extends Statement {
	public function offset(int $offset): Offset;
}