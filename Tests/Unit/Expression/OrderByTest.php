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
final class OrderByTest extends Tester\TestCase {
	public function testIgnoringStatementForEmpty(): void {
		Assert::same('', (new Expression\OrderBy([]))->sql());
	}

	public function testDefaultAscOrderBy(): void {
		Assert::same(
			'name ASC, age DESC, title ASC, position ASC',
			(new Expression\OrderBy(['name', 'age' => 'DESC', 'title', 'position' => 'ASC']))->sql(),
		);
	}
}
(new OrderByTest())->run();
