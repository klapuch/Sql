<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class Parameters {
	private $parameters;

	public function __construct(array ...$parameters) {
		$this->parameters = $parameters;
	}

	public function bind(array $parameters): self {
		return new self(...$this->parameters, ...[$parameters]);
	}

	public function binds(): array {
		$duplications = $this->duplications(...$this->parameters);
		if ($duplications) {
			throw new \UnexpectedValueException(
				sprintf('Keys can not be duplicated: %s', implode(', ', $duplications))
			);
		}
		return array_merge(...$this->parameters);
	}

	private function duplications(array ...$parameters): array {
		return array_filter(array_keys(array_intersect_key(...array_pad($parameters, 2, []))), 'is_string');
	}
}