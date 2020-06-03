<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class Parameter {
	/** @var string */
	private $column;

	/** @var int */
	private $id;

	public function __construct(string $column, int $id) {
		$this->column = $column;
		$this->id = $id;
	}

	public function __toString(): string {
		if (strpos($this->column, '.') !== false)
			$column = str_replace('.', '__', $this->column);
		else
			$column = $this->column;
		return sprintf('_%d_%s', $this->id, $column);
	}
}
