<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

/**
 * Parameters made flat
 * [book => [author => myself]] made book_author with value myself
 */
final class FlatParameters implements Parameters {
	private $origin;

	public function __construct(Parameters $origin) {
		$this->origin = $origin;
	}

	public function bind(array $parameters): Parameters {
		return new self($this->origin->bind($parameters));
	}

	public function binds(): array {
		return $this->flatten($this->origin->binds());
	}

	private function flatten($array, $prefix = ''): array {
		return array_reduce(
			array_keys($array),
			function(array $flatten, $key) use ($array, $prefix): array {
				if (is_array($array[$key])) {
					$flatten += $this->flatten($array[$key], $prefix . $key . '_');
				} else {
					$flatten[$prefix . $key] = $array[$key];
				}
				return $flatten;
			},
			[]
		);
	}
}