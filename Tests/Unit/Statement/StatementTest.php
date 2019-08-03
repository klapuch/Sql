<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Statement;

use Klapuch\Sql\Expression;
use Klapuch\Sql\Statement;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class StatementTest extends Tester\TestCase {
	public function testPassingWithEmptyParameters(): void {
		Assert::same(
			[],
			(new Statement\Select\Query())
				->select(new Expression\Select(['firstname']))
				->from(new Expression\From(['world']))
				->parameters(),
		);
	}

	public function testHandlingNamedParameters(): void {
		Assert::same(
			['a' => 'b', 'c' => 'd', 'e' => 'f'],
			(new Statement\Select\Query())
				->select(new Expression\Select(['firstname'], ['a' => 'b']))
				->from(new Expression\From(['world']))
				->where(new Expression\RawWhere('1=1', ['c' => 'd']))
				->where(new Expression\RawWhere('2=2', ['e' => 'f']))
				->parameters(),
		);
	}
}
(new StatementTest())->run();
