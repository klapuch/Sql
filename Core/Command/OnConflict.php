<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Command;

final class OnConflict implements Command {
	/** @var string[] */
	private $columns;

	public function __construct(array $columns) {
		$this->columns = $columns;
	}

	public function sql(): string {
		return sprintf('ON CONFLICT (%s)', implode(', ', $this->columns));
	}

	public function parameters(): array {
		return [];
	}
}
