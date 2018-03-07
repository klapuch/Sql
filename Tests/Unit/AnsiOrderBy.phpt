<?php
declare(strict_types = 1);

/**
 * @testCase
 * @phpVersion > 7.2
 */
namespace Klapuch\Sql\Unit;

use Klapuch\Sql;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class AnsiOrderBy extends Tester\TestCase {
	public function testIgnoringClauseForEmpty() {
		Assert::same(
			'',
			(new Sql\AnsiOrderBy(new Sql\FakeClause(), [], []))->sql()
		);
	}
}

(new AnsiOrderBy())->run();