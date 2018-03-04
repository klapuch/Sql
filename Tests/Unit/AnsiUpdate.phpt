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

final class AnsiUpdate extends Tester\TestCase {
	public function testFullUpdate() {
		Assert::same(
			'UPDATE world SET mood = ?, age = ? WHERE age > 50 AND age > 40 OR name LIKE ?',
			(new Sql\AnsiUpdate('world'))
				->set(['mood' => '?', 'age' => '?'])
				->where('age > 50')
				->where('age > 40')
				->orWhere('name LIKE ?')
				->sql()
		);
	}
}

(new AnsiUpdate())->run();