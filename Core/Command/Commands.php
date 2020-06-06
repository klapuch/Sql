<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Command;

final class Commands implements Command {
	/** @var \Klapuch\Sql\Command\Command[] */
	private $commands;

	public function __construct(Command ...$commands) {
		$this->commands = $commands;
	}

	public function sql(): string {
		return trim(implode(
			' ',
			array_filter(
				array_map(static function (Command $command): string {
					return $command->sql();
				}, $this->commands),
			),
		));
	}

	/**
	 * @return mixed[]
	 */
	public function parameters(): array {
		return array_merge(
			[],
			...array_map(static function (Command $command): array {
				   return $command->parameters();
			}, $this->commands),
		);
	}
}
