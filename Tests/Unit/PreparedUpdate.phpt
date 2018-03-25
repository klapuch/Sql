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
		$clause = (new Sql\PreparedUpdate(new Sql\AnsiUpdate('world')))
			->set(['mood' => 'good', 'age' => 20]);
		Assert::same('UPDATE world SET mood = ?, age = ?', $clause->sql());
		Assert::same(['good', 20], $clause->parameters()->binds());
	}
}

(new PreparedUpdate())->run();