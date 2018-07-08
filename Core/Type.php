<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Type {
	public function sql(): string;
	public function parameters(): Parameters;
}