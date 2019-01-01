<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Conflict extends Statement {
	public function doUpdate(array $values = [], array $parameters = []): DoUpdate;

	public function doNothing(): DoNothing;
}
