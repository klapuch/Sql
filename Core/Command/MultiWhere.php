<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Command;

use Klapuch\Sql\Expression\Expressions;

final class MultiWhere implements Command {
	/** @var \Klapuch\Sql\Command\Command */
	private $command;

	public function __construct(array $where) {
		$this->command = new CustomCommand(
			'WHERE',
			new Expressions(
				sprintf(' %s ', (string) array_key_last($where)),
				new Expressions(sprintf(' %s ', 'AND'), ...$where['AND']),
				new Expressions(sprintf(' %s ', 'OR'), ...$where['OR']),
			),
		);
	}

	public function sql(): string {
		return $this->command->sql();
	}

	public function parameters(): array {
		return $this->command->parameters();
	}
}
