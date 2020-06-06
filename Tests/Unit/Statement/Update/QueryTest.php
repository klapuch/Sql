<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Statement\Update;

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
			'UPDATE world SET firstname = 1, lastname = 2 FROM people WHERE (1 = 1) RETURNING *',
			(new Statement\Update\Query())
				->update('world')
				->set(new Expression\RawSet('firstname = 1'))
				->set(new Expression\RawSet('lastname = 2'))
				->from(new Expression\From(['people']))
				->where(new Expression\RawWhere('1 = 1'))
				->returning(new Sql\Command\Returning(['*']))
				->sql(),
		);
	}
}
(new QueryTest())->run();
