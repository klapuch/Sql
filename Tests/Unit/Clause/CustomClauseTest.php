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
final class CustomClauseTest extends Tester\TestCase {
	public function testFilteringEmpty(): void {
		Assert::same(
			'',
			(new Clause\CustomClause(
				'GROUP BY',
				new Expression\GroupBy(''),
			))->sql(),
		);
	}

	public function testConcatenate(): void {
		Assert::same(
			'GROUP BY firstname',
			(new Clause\CustomClause(
				'GROUP BY',
				new Expression\GroupBy('firstname'),
			))->sql(),
		);
	}
}
(new CustomClauseTest())->run();
