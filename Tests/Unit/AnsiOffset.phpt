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

final class AnsiOffset extends Tester\TestCase {
	public function testIgnoringOffsetClauseForExplicitZero() {
		Assert::same(
			'',
			(new Sql\AnsiOffset(new Sql\FakeClause(), 0, []))->sql()
		);
	}
}

(new AnsiOffset())->run();