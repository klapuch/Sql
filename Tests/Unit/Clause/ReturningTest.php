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
final class ReturningTest extends Tester\TestCase {
	public function testSingleColumn(): void {
		Assert::same('RETURNING foo', (new Clause\Returning(['foo']))->sql());
	}

	public function testMultipleColumns(): void {
		Assert::same('RETURNING foo, bar', (new Clause\Returning(['foo', 'bar']))->sql());
	}
}
(new ReturningTest())->run();
