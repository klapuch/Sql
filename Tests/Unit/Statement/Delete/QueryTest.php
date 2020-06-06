<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Statement\Delete;

use Klapuch\Sql;
use Klapuch\Sql\Expression;
use Klapuch\Sql\Statement;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class QueryTest extends Tester\TestCase {
	public function testBuilding(): void {
		Assert::same(
			'DELETE FROM world WHERE (age > 10) RETURNING firstname',
			(new Statement\Delete\Query())
				->from('world')
				->where(new Expression\RawWhere('age > 10'))
				->returning(new Sql\Command\Returning(['firstname']))
				->sql(),
		);
	}
}
(new QueryTest())->run();
