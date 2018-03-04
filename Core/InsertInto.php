<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface InsertInto extends Clause {
	public function returning(array $columns, array $parameters = []): Returning;
	public function onConflict(array $target = []): Conflict;
}