<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Command;

use Klapuch\Sql\Expression\Expression;
use Klapuch\Sql\Expression\Expressions;

final class Where implements Command {
	/** @var \Klapuch\Sql\Command\Command */
	private $command;

	public function __construct(string $operator, Expression ...$expressions) {
		$this->command = new CustomCommand('WHERE', new Expressions(sprintf(' %s ', $operator), ...$expressions));
	}

	public function sql(): string {
		return $this->command->sql();
	}

	public function parameters(): array {
		return $this->command->parameters();
	}
}
