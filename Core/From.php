<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface From extends Selection {
	public function where(string $comparison, array $parameters = []): Where;

	public function whereIn(string $column, array $parameters = []): Where;

	public function join(string $type, string $table, string $condition, array $parameters = []): Join;

	public function groupBy(array $columns): GroupBy;

	public function having(string $condition, array $parameters = []): Having;

	public function orderBy(array $orders): OrderBy;

	public function limit(int $limit): Limit;

	public function offset(int $offset): Offset;
}
