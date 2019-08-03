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
final class GroupByTest extends Tester\TestCase {
	public function testSingleColumn(): void {
		Assert::same('foo', (new Expression\GroupBy('foo'))->sql());
	}

	public function testMultipleColumns(): void {
		Assert::same('foo, bar', (new Expression\GroupBy('foo', 'bar'))->sql());
	}
}
(new GroupByTest())->run();
