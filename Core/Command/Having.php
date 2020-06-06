<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Command;

use Klapuch\Sql\Expression\Expression;
use Klapuch\Sql\Expression\Expressions;

final class Having implements Command {
	private const SEPARATOR = ', ';

	/** @var \Klapuch\Sql\Command\Command */
	private $command;

	public function __construct(Expression ...$expressions) {
		$this->command = new CustomCommand('HAVING', new Expressions(self::SEPARATOR, ...$expressions));
	}

	public function sql(): string {
		return $this->command->sql();
	}

	public function parameters(): array {
		return $this->command->parameters();
	}
}
