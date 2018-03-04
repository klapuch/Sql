<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Update extends Clause {
	public function set(array $values, array $parameters = []): Set;
}