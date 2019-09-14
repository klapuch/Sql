<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class Aliases {
	/** @var string[] */
	private $list;

	public function __construct(array $list) {
		$this->list = $list;
	}

	public function __toString(): string {
		return implode(
			', ',
			array_map(
				static function ($alias, string $real): string {
					return is_int($alias) ? $real : implode(' AS ', [$real, $alias]);
				},
				array_keys($this->list),
				$this->list,
			),
		);
	}
}
