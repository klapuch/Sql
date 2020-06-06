<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Command;

use Klapuch\Sql\Command;
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
			(new Command\MultiInsertInto('world', ['firstname' => ['a'], 'lastname' => ['c']]))->sql(),
		);
		Assert::same(
			['firstname__1' => 'a', 'lastname__1' => 'c'],
			(new Command\MultiInsertInto('world', ['firstname' => ['a'], 'lastname' => ['c']]))->parameters(),
		);
	}

	public function testNamedParameters(): void {
		Assert::same(
			'INSERT INTO world (firstname, lastname) VALUES (:firstname__1, :lastname__1), (:firstname__2, :lastname__2)',
			(new Command\MultiInsertInto('world', ['firstname' => ['a', 'b'], 'lastname' => ['c', 'd']]))->sql(),
		);
		Assert::same(
			['firstname__1' => 'a', 'lastname__1' => 'c', 'firstname__2' => 'b', 'lastname__2' => 'd'],
			(new Command\MultiInsertInto('world', ['firstname' => ['a', 'b'], 'lastname' => ['c', 'd']]))->parameters(),
		);
		Assert::same(
			'INSERT INTO world (firstname, lastname) VALUES (:firstname__1, :lastname__1), (:firstname__2, :lastname__2), (:firstname__3, :lastname__3)',
			(new Command\MultiInsertInto('world', ['firstname' => ['a', 'b', 'c'], 'lastname' => ['d', 'e', 'f']]))->sql(),
		);
		Assert::same(
			['firstname__1' => 'a', 'lastname__1' => 'd', 'firstname__2' => 'b', 'lastname__2' => 'e', 'firstname__3' => 'c', 'lastname__3' => 'f'],
			(new Command\MultiInsertInto('world', ['firstname' => ['a', 'b', 'c'], 'lastname' => ['d', 'e', 'f']]))->parameters(),
		);
	}
}
(new MultiInsertIntoTest())->run();
