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

final class PreparedUpdate extends Tester\TestCase {
	public function testConversionToPrepareStatement() {
		$statement = (new Sql\PreparedUpdate(new Sql\AnsiUpdate('world')))
			->set(['mood' => 'good', 'age' => 20]);
		Assert::same('UPDATE world SET mood = :mood, age = :age', $statement->sql());
		Assert::same(['mood' => 'good', 'age' => 20], $statement->parameters()->binds());
	}
}

(new PreparedUpdate())->run();