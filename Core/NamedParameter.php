<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class NamedParameter {
	/** @var int */
	private static $id = 0;

	/** @var string */
	private $column;

	public function __construct(string $column) {
		$this->column = $column;
		++self::$id;
	}

	public function __toString(): string {
		return (string) new Parameter($this->column, self::$id);
	}
}
