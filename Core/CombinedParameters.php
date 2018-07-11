<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

/**
 * Parameters combined together
 */
final class CombinedParameters implements Parameters {
	private $parameters;

	public function __construct(Parameters ...$parameters) {
		$this->parameters = $parameters;
	}

	public function bind(array $parameters): Parameters {
		return new self(
			...$this->parameters,
			...[new UniqueParameters($parameters)]
		);
	}

	public function binds(): array {
		return (new UniqueParameters(
			...array_map(
				function(Parameters $parameters): array {
					return $parameters->binds();
				},
				$this->parameters
			)
		))->binds();
	}
}