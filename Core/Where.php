<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Where extends Clause {
	public function where(string $condition, array $parameters = []): self;
	public function orWhere(string $condition, array $parameters = []): self;
	public function groupBy(array $columns): GroupBy;
	public function having(string $condition, array $parameters = []): Having;
	public function orderBy(array $orders): OrderBy;
	public function limit(int $limit): Limit;
	public function offset(int $offset): Offset;
}