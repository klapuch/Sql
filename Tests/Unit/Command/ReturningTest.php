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
final class ReturningTest extends Tester\TestCase {
	public function testSingleColumn(): void {
		Assert::same('RETURNING foo', (new Command\Returning(['foo']))->sql());
	}

	public function testMultipleColumns(): void {
		Assert::same('RETURNING foo, bar', (new Command\Returning(['foo', 'bar']))->sql());
	}
}
(new ReturningTest())->run();
