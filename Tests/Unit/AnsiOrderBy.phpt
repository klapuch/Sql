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
	public function testIgnoringStatementForEmpty() {
		Assert::same(
			'',
			(new Sql\AnsiOrderBy(new Sql\FakeStatement(), [], []))->sql()
		);
	}

	public function testDefaultAscOrderBy() {
		Assert::same(
			' ORDER BY name ASC, age DESC, title ASC, position ASC',
			(new Sql\AnsiOrderBy(new Sql\FakeStatement(), ['name', 'age' => 'DESC', 'title', 'position' => 'ASC'], []))->sql()
		);
	}
}

(new AnsiOrderBy())->run();
