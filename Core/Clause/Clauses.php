<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Clause;

final class Clauses implements Clause {
	/** @var \Klapuch\Sql\Clause\Clause[] */
	private $clauses;

	public function __construct(Clause ...$clauses) {
		$this->clauses = $clauses;
	}

	public function sql(): string {
		return trim(implode(
			' ',
			array_filter(
				array_map(static function (Clause $clause): string {
					return $clause->sql();
				}, $this->clauses),
			),
		));
	}

	/**
	 * @return mixed[]
	 */
	public function parameters(): array {
		return array_merge(
			[],
			...array_map(static function (Clause $clause): array {
				   return $clause->parameters();
			}, $this->clauses),
		);
	}
}
