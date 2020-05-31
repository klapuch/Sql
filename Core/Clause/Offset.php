<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

final class Offset implements Clause {
	private const NO_OFFSET = '';

	/** @var int */
	private $offset;

	public function __construct(int $offset) {
		$this->offset = $offset;
	}

	public function sql(): string {
		return $this->offset === 0
			? self::NO_OFFSET
			: sprintf('OFFSET %d', $this->offset);
	}

	public function parameters(): array {
		return [];
	}
}
