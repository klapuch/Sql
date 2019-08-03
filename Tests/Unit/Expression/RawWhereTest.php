<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Expression;

use Klapuch\Sql\Expression;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class RawWhereTest extends Tester\TestCase {
	public function testSingleCondition(): void {
		Assert::same('(foo = ?)', (new Expression\RawWhere('foo = ?'))->sql());
	}

	public function testLogicalOperators(): void {
		Assert::same('(foo = ? AND 1=1)', (new Expression\RawWhere('foo = ?'))->and('1=1')->sql());
		Assert::same('(foo = ? OR 1=1)', (new Expression\RawWhere('foo = ?'))->or('1=1')->sql());
		Assert::same('(foo = ? OR 1=1 AND 2=2)', (new Expression\RawWhere('foo = ?'))->or('1=1')->and('2=2')->sql());
	}

	public function testKeepingOrderOfParameters(): void {
		Assert::same([1, 2], (new Expression\RawWhere('foo = ?', [1]))->and('bar = ?', [2])->parameters());
		Assert::same([1, 2], (new Expression\RawWhere('foo = ?', [1]))->or('bar = ?', [2])->parameters());
	}
}
(new RawWhereTest())->run();
