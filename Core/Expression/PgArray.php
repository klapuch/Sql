<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

use Klapuch\Sql\NamedParameters;

final class PgArray implements Expression {
	private const IDENTIFIER = 'pg_array';

	/** @var string */
	private $type;

	/** @var \Klapuch\Sql\NamedParameters */
	private $parameters;

	public function __construct(array $values, string $type) {
		$this->type = strtolower($type);
		$this->parameters = new NamedParameters($values, sprintf('%s__%s__%d', self::IDENTIFIER, $this->type, spl_object_id($this)));
	}

	public function sql(): string {
		return sprintf('ARRAY[%s]::%s[]', implode(', ', $this->parameters->names()), $this->type);
	}

	public function parameters(): array {
		return $this->parameters->values();
	}
}
