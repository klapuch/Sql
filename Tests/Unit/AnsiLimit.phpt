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

final class AnsiLimit extends Tester\TestCase {
	public function testIgnoringLimitClauseForIntMax() {
		Assert::same(
			'',
			(new Sql\AnsiLimit(new Sql\FakeClause(), PHP_INT_MAX, []))->sql()
		);
	}
}

(new AnsiLimit())->run();