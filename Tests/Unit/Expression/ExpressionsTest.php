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
final class ExpressionsTest extends Tester\TestCase {
	public function testFilteringEmpty(): void {
		Assert::same(
			'',
			(new Expression\Expressions(', ', new Expression\Select([])))->sql(),
		);
		Assert::same(
			'a, b',
			(new Expression\Expressions(', ', new Expression\Select(['a']), new Expression\Select([]), new Expression\Select(['b'])))->sql(),
		);
	}

	public function testAllowingEmptyParameters(): void {
		Assert::same(
			[],
			(new Expression\Expressions(', '))->parameters(),
		);
	}
}
(new ExpressionsTest())->run();
