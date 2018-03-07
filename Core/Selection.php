<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Selection extends Clause {
	public function where(string $condition, array $parameters = []): Where;
	public function orderBy(array $orders): OrderBy;
	public function limit(int $limit): Limit;
	public function offset(int $offset): Offset;
}