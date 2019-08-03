<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Clause;

use Klapuch\Sql\Clause;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class MultiInsertIntoTest extends Tester\TestCase {
	public function testMultiAsSingle(): void {
		Assert::same(
			'INSERT INTO world (firstname, lastname) VALUES (:firstname__1, :lastname__1)',
			(new Clause\MultiInsertInto('world', ['firstname' => ['a'], 'lastname' => ['c']]))->sql(),
		);
		Assert::same(
			['firstname__1' => 'a', 'lastname__1' => 'c'],
			(new Clause\MultiInsertInto('world', ['firstname' => ['a'], 'lastname' => ['c']]))->parameters(),
		);
	}

	public function testNamedParameters(): void {
		Assert::same(
			'INSERT INTO world (firstname, lastname) VALUES (:firstname__1, :lastname__1), (:firstname__2, :lastname__2)',
			(new Clause\MultiInsertInto('world', ['firstname' => ['a', 'b'], 'lastname' => ['c', 'd']]))->sql(),
		);
		Assert::same(
			['firstname__1' => 'a', 'lastname__1' => 'c', 'firstname__2' => 'b', 'lastname__2' => 'd'],
			(new Clause\MultiInsertInto('world', ['firstname' => ['a', 'b'], 'lastname' => ['c', 'd']]))->parameters(),
		);
		Assert::same(
			'INSERT INTO world (firstname, lastname) VALUES (:firstname__1, :lastname__1), (:firstname__2, :lastname__2), (:firstname__3, :lastname__3)',
			(new Clause\MultiInsertInto('world', ['firstname' => ['a', 'b', 'c'], 'lastname' => ['d', 'e', 'f']]))->sql(),
		);
		Assert::same(
			['firstname__1' => 'a', 'lastname__1' => 'd', 'firstname__2' => 'b', 'lastname__2' => 'e', 'firstname__3' => 'c', 'lastname__3' => 'f'],
			(new Clause\MultiInsertInto('world', ['firstname' => ['a', 'b', 'c'], 'lastname' => ['d', 'e', 'f']]))->parameters(),
		);
	}
}
(new MultiInsertIntoTest())->run();
