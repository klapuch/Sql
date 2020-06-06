<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Statement\Insert;

use Klapuch\Sql;
use Klapuch\Sql\Command;
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
			'INSERT INTO world (firstname, lastname) VALUES (coalesce(?), ?) ON CONFLICT (firstname, lastname) DO UPDATE SET firstname = 1, lastname = 2 RETURNING *',
			(new Statement\Insert\Query())
				->insertInto(new Sql\Command\RawInsertInto('world', ['firstname' => 'coalesce(?)', 'lastname' => '?'], ['foo', 'bar']))
				->returning(new Sql\Command\Returning(['*']))
				->onConflict(new Sql\Command\OnConflict(['firstname', 'lastname']))
				->doUpdate()
				->set(new Expression\RawSet('firstname = 1'))
				->set(new Expression\RawSet('lastname = 2'))
				->sql(),
		);
		Assert::same(
			'INSERT INTO world (firstname, lastname) VALUES (coalesce(?), ?) ON CONFLICT (firstname, lastname) DO NOTHING RETURNING *',
			(new Statement\Insert\Query())
				->insertInto(new Command\RawInsertInto('world', ['firstname' => 'coalesce(?)', 'lastname' => '?'], ['foo', 'bar']))
				->returning(new Command\Returning(['*']))
				->onConflict(new Command\OnConflict(['firstname', 'lastname']))
				->doNothing()
				->sql(),
		);
		Assert::same(
			'INSERT INTO world (firstname, lastname) VALUES (:_1_firstname, :_1_lastname) ON CONFLICT (firstname, lastname) DO NOTHING RETURNING *',
			(new Statement\Insert\Query())
				->insertInto(new Command\InsertInto('world', ['firstname' => 'abc', 'lastname' => 'def']))
				->returning(new Command\Returning(['*']))
				->onConflict(new Command\OnConflict(['firstname', 'lastname']))
				->doNothing()
				->sql(),
		);
	}
}
(new QueryTest())->run();
