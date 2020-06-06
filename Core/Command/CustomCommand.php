<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Command;

use Klapuch\Sql\Expression\Expression;

final class CustomCommand implements Command {
	/** @var string */
	private $name;

	/** @var \Klapuch\Sql\Expression\Expression */
	private $expression;

	public function __construct(string $name, Expression $expression) {
		$this->name = $name;
		$this->expression = $expression;
	}

	public function sql(): string {
		$sql = $this->expression->sql();
		if ($sql === '')
			return '';
		return sprintf('%s %s', $this->name, $sql);
	}

	/**
	 * @return mixed[]
	 */
	public function parameters(): array {
		return $this->expression->parameters();
	}
}
