<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

final class Limit implements Clause {
	private const NO_LIMIT = '';

	/** @var int */
	private $limit;

	public function __construct(int $limit) {
		$this->limit = $limit;
	}

	public function sql(): string {
		return $this->limit === PHP_INT_MAX
			? self::NO_LIMIT
			: sprintf('LIMIT %d', $this->limit);
	}

	public function parameters(): array {
		return [];
	}
}
