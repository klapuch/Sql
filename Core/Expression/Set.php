<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

use Klapuch\Sql;

final class Set implements Expression {
	/** @var \Klapuch\Sql\NamedParameters */
	private $assigning;

	public function __construct(array $assigning) {
		$this->assigning = new Sql\NamedParameters($assigning);
	}

	public function sql(): string {
		$sql = [];
		foreach ($this->assigning->names() as $column => $value) {
			$sql[] = "$column = $value";
		}
		return implode(', ', $sql);
	}

	public function parameters(): array {
		return $this->assigning->values();
	}
}
