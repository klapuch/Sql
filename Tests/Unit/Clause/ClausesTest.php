<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Clause;

use Klapuch\Sql\Clause;
use Klapuch\Sql\Expression;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class ClausesTest extends Tester\TestCase {
	public function testFilteringEmpty(): void {
		Assert::same(
			'',
			(new Clause\Clauses(
				new Clause\GroupBy(),
				new Clause\Having(new Expression\EmptyExpression()),
			))->sql(),
		);
		Assert::same(
			'GROUP BY a HAVING (b)',
			(new Clause\Clauses(
				new Clause\GroupBy(new Expression\GroupBy('a')),
				new Clause\Having(new Expression\EmptyExpression()),
				new Clause\Having(new Expression\Having('b')),
			))->sql(),
		);
	}

	public function testAllowingEmptyParameters(): void {
		Assert::same(
			[],
			(new Clause\Clauses())->parameters(),
		);
	}
}
(new ClausesTest())->run();
