<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

interface Parameters {
	/**
	 * Bind new parameters to the existing one
	 *
	 * @param mixed[] $parameters
	 * @return self
	 */
	public function bind(array $parameters): self;

	/**
	 * All the binds
	 *
	 * @return mixed[]
	 */
	public function binds(): array;
}