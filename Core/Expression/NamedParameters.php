<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

final class NamedParameters implements Expression {
	/** @var Expression */
	private $origin;

	/** @var string */
	private $column;

	public function __construct(Expression $origin, string $column) {
		$this->origin = $origin;
		$this->column = $column;
	}

	public function sql(): string {
		return preg_replace_callback('~\?~', function (): string {
			static $position = 0;
			return sprintf(':%s__%d', $this->column, ++$position);
		}, $this->origin->sql());
	}

	/**
	 * @return mixed[]
	 */
	public function parameters(): array {
		[$columns, $parameters] = [[], $this->origin->parameters()];
		for ($position = 1; $position <= count($parameters); ++$position)
			$columns[] = sprintf('%s__%d', $this->column, $position);
		return (array) array_combine($columns, $parameters);
	}
}
