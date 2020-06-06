<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Command;

use Klapuch\Sql\Command;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';
/**
 * @testCase
 */
final class LimitTest extends Tester\TestCase {
	public function testNoLimitForBiggestNumber(): void {
		Assert::same('', (new Command\Limit(PHP_INT_MAX))->sql());
	}

	public function testRealLimit(): void {
		Assert::same('LIMIT 10', (new Command\Limit(10))->sql());
	}
}
(new LimitTest())->run();
