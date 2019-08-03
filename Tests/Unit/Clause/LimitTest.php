<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Clause;

use Klapuch\Sql\Clause;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';
/**
 * @testCase
 */
final class LimitTest extends Tester\TestCase {
	public function testNoLimitForBiggestNumber(): void {
		Assert::same('', (new Clause\Limit(PHP_INT_MAX))->sql());
	}

	public function testRealLimit(): void {
		Assert::same('LIMIT 10', (new Clause\Limit(10))->sql());
	}
}
(new LimitTest())->run();
