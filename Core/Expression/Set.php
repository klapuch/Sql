<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Expression;

use Klapuch\Sql;

final class Set implements Expression {
	/** @var mixed[] */
	private $assigning;

	/** @var Sql\PreparedStatement */
	private $preparedStatement;

	public function __construct(array $assigning) {
		$this->assigning = $assigning;
		$this->preparedStatement = new Sql\PreparedStatement($assigning);
	}

	public function sql(): string {
		$sql = $this->preparedStatement->sql();
		return implode(
			', ',
			array_map(static function (string $column, string $value): string {
				return implode(' = ', [$column, $value]);
			}, array_keys($sql), $sql),
		);
	}

	public function parameters(): array {
		return $this->preparedStatement->parameters();
	}
}
