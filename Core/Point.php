<?php
declare(strict_types = 1);

namespace Klapuch\Sql;

final class Point implements Type {
	/** @var \Klapuch\Sql\Type */
	private $x;

	/** @var \Klapuch\Sql\Type */
	private $y;

	public function __construct(Type $x, Type $y) {
		$this->x = $x;
		$this->y = $y;
	}

	public function expression(): string {
		return sprintf('POINT(%s, %s)', $this->x->expression(), $this->y->expression());
	}
}
