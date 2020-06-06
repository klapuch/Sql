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
final class OffsetTest extends Tester\TestCase {
	public function testRealLimit(): void {
		Assert::same('OFFSET 10', (new Command\Offset(10))->sql());
	}

	public function testLeavingOffsetForZero(): void {
		Assert::same('', (new Command\Offset(0))->sql());
	}
}
(new OffsetTest())->run();
