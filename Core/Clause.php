<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Clause {
	public function sql(): string;
}