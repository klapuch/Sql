<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface GroupBy extends Clause {
	public function having(string $condition, array $parameters = []): Having;
	public function orderBy(array $orders): OrderBy;
	public function limit(int $limit): Limit;
	public function offset(int $offset): Offset;
}