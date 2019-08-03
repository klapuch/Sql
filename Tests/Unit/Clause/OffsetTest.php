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
final class OffsetTest extends Tester\TestCase {
	public function testRealLimit(): void {
		Assert::same('OFFSET 10', (new Clause\Offset(10))->sql());
	}

	public function testLeavingOffsetForZero(): void {
		Assert::same('', (new Clause\Offset(0))->sql());
	}
}
(new OffsetTest())->run();
