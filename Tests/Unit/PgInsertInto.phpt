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

	public function testOnConflictUpdate() {
		Assert::same(
			'INSERT INTO world (name) VALUES (?) ON CONFLICT DO UPDATE SET name = ?',
			(new Sql\PgInsertInto('world', ['name' => '?']))
				->onConflict()
				->doUpdate(['name' => '?'])
				->sql()
		);
	}

	public function testOnConflictTargetUpdate() {
		Assert::same(
			'INSERT INTO world (name) VALUES (?) ON CONFLICT (foo, bar) DO UPDATE SET name = ?',
			(new Sql\PgInsertInto('world', ['name' => '?']))
				->onConflict(['foo', 'bar'])
				->doUpdate(['name' => '?'])
				->sql()
		);
	}

	public function testOnConflictDoNothing() {
		Assert::same(
			'INSERT INTO world (name) VALUES (?) ON CONFLICT DO NOTHING',
			(new Sql\PgInsertInto('world', ['name' => '?']))
				->onConflict()
				->doNothing()
				->sql()
		);
	}
}

(new PgInsertInto())->run();