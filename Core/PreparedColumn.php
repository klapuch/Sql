<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class PreparedColumn {
	/** @var string */
	private $column;

	public function __construct(string $column) {
		$this->column = $column;
	}

	public function __toString(): string {
		if (strpos($this->column, '.') !== false)
			return sprintf('_%s', str_replace('.', '__', $this->column));
		return $this->column;
	}
}
