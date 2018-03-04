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

final class PgInsertInto extends Tester\TestCase {
	public function testFullInsert() {
		Assert::same(
			'INSERT INTO world (name, age) VALUES (?, :age) RETURNING name, *',
			(new Sql\PgInsertInto('world', ['name' => '?', 'age' => ':age']))
				->returning(['name', '*'])
				->sql()
		);
	}

	public function testAllParameters() {
		Assert::same(
			['Dom', 'age' => 20, 'god', 'myself'],
			(new Sql\PgInsertInto('world', ['name' => '?', 'age' => ':age'], ['Dom', 'age' => 20]))
				->onConflict()
				->doUpdate(['name' => '?'], ['god'])
				->returning(['name', '*', '?'], ['myself'])
				->parameters()
				->binds()
		);
		Assert::same(
			['Dom', 'age' => 20, 'myself'],
			(new Sql\PgInsertInto('world', ['name' => '?', 'age' => ':age'], ['Dom', 'age' => 20]))
				->onConflict()
				->doNothing()
				->returning(['name', '*', '?'], ['myself'])
				->parameters()
				->binds()
		);
	}

	public function testOnConflictUpdate() {
		Assert::same(
			'INSERT INTO world (name) VALUES (?) ON CONFLICT DO UPDATE SET name = ? RETURNING name, *',
			(new Sql\PgInsertInto('world', ['name' => '?']))
				->onConflict()
				->doUpdate(['name' => '?'])
				->returning(['name', '*'])
				->sql()
		);
	}

	public function testOnConflictTargetUpdate() {
		Assert::same(
			'INSERT INTO world (name) VALUES (?) ON CONFLICT (foo, bar) DO UPDATE SET name = ? RETURNING name, *',
			(new Sql\PgInsertInto('world', ['name' => '?']))
				->onConflict(['foo', 'bar'])
				->doUpdate(['name' => '?'])
				->returning(['name', '*'])
				->sql()
		);
	}

	public function testOnConflictDoNothing() {
		Assert::same(
			'INSERT INTO world (name) VALUES (?) ON CONFLICT DO NOTHING RETURNING name, *',
			(new Sql\PgInsertInto('world', ['name' => '?']))
				->onConflict()
				->doNothing()
				->returning(['name', '*'])
				->sql()
		);
	}
}

(new PgInsertInto())->run();