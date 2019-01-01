<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class Parameter implements Type {
	/** @var string */
	private $value;

	public function __construct(string $value) {
		$this->value = $value;
	}

	public function expression(): string {
		if (substr($this->value, 0, 1) === ':' || $this->value === '?')
			return $this->value;
		throw new \UnexpectedValueException(sprintf('Parameter "%s" is invalid', $this->value));
	}
}
