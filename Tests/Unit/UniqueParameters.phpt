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

final class UniqueParameters extends Tester\TestCase {
	public function testAddingNewParameter() {
		Assert::same(['Dom'], (new Sql\UniqueParameters())->bind(['Dom'])->binds());
	}

	public function testKeepingOrder() {
		Assert::same(['Dom', 20, 'Klapuch'], (new Sql\UniqueParameters(['Dom', 20]))->bind(['Klapuch'])->binds());
		Assert::same(['Dom', 20, 'Klapuch'], (new Sql\UniqueParameters())->bind(['Dom', 20])->bind(['Klapuch'])->binds());
	}

	public function testThrowingOnDuplication() {
		Assert::exception(function () {
			(new Sql\UniqueParameters(['name' => 'Dom']))->bind(['name' => 'God'])->binds();
		}, \UnexpectedValueException::class, 'Keys can not be duplicated: name');
	}
}

(new UniqueParameters())->run();