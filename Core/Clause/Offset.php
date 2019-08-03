<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

final class Offset implements Clause {
	/** @var int */
	private $offset;

	public function __construct(int $offset) {
		$this->offset = $offset;
	}

	public function sql(): string {
		return $this->offset === 0 ? '' : sprintf('OFFSET %d', $this->offset);
	}

	public function parameters(): array {
		return [];
	}
}
