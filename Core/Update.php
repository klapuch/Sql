<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Update extends Statement {
	public function set(array $values, array $parameters = []): Set;
}