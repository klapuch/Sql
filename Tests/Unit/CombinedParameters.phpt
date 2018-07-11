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

final class CombinedParameters extends Tester\TestCase {
	public function testCombinedBinds() {
		Assert::same(
			['Dom', 'title' => 'Developer'],
			(new Sql\CombinedParameters(
				new Sql\UniqueParameters(['Dom']),
				new Sql\UniqueParameters(['title' => 'Developer'])
			))->binds()
		);
	}

	public function testKeepingNewAddedLast() {
		Assert::same(
			['Dom', 'Sql', 'title' => 'Developer'],
			(new Sql\CombinedParameters(
				new Sql\UniqueParameters(['Dom']),
				new Sql\UniqueParameters(['Sql'])
			))->bind(['title' => 'Developer'])->binds()
		);
	}

	public function testKeepingAllWithDuplicates() {
		Assert::same(
			['Dom', 'title' => 'Developer', 'Dom'],
			(new Sql\CombinedParameters(
				new Sql\UniqueParameters(['Dom']),
				new Sql\UniqueParameters(['title' => 'DeveloperX']),
				new Sql\UniqueParameters(['title' => 'Developer']),
				new Sql\UniqueParameters(['Dom'])
			))->binds()
		);
	}
}

(new CombinedParameters())->run();