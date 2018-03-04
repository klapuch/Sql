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

final class PgMultiInsertInto extends Tester\TestCase {
	public function testAllClauses() {
		Assert::same(
			'INSERT INTO world (name, age) VALUES (?, :age), (?, :age2)',
			(new Sql\PgMultiInsertInto(
				'world',
				['name' => ['?', '?'], 'age' => [':age', ':age2']]
			))->sql()
		);
	}

	public function testAllParameters() {
		Assert::same(
			['Dom', 'age' => 20, 'god', 'myself'],
			(new Sql\PgMultiInsertInto('world', ['name' => ['?', '?'], 'age' => [':age', ':age2']], ['Dom', 'age' => 20]))
				->onConflict()
				->doUpdate(['name' => '?'], ['god'])
				->returning(['name', '*', '?'], ['myself'])
				->parameters()
				->binds()
		);
		Assert::same(
			['Dom', 'age' => 20, 'myself'],
			(new Sql\PgMultiInsertInto('world', ['name' => ['?', '?'], 'age' => [':age', ':age2']], ['Dom', 'age' => 20]))
				->onConflict()
				->doNothing()
				->returning(['name', '*', '?'], ['myself'])
				->parameters()
				->binds()
		);
	}
}

(new PgMultiInsertInto())->run();