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

final class AnsiMultiInsertInto extends Tester\TestCase {
	public function testInsertingMultipleColumns() {
		Assert::same(
			'INSERT INTO world (name, age) VALUES (?, :age), (?, :age2)',
			(new Sql\AnsiMultiInsertInto(
				'world',
				['name' => ['?', '?'], 'age' => [':age', ':age2']]
			))->sql()
		);
	}
}

(new AnsiMultiInsertInto())->run();