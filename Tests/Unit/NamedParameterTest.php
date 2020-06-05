<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit;

use Klapuch\Sql;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';
/**
 * @testCase
 */
final class NamedParameterTest extends Tester\TestCase {
	public function testTableColumnToPreparedColumns(): void {
		$parameter = new Sql\NamedParameter('users.name');
		Assert::same(':_1_users__name', $parameter->name());
		Assert::same('_1_users__name', $parameter->value());
		$parameter = new Sql\NamedParameter('users.name.something');
		Assert::same(':_2_users__name__something', $parameter->name());
		Assert::same('_2_users__name__something', $parameter->value());
	}

	public function testKeepingNormalColumns(): void {
		$parameter = new Sql\NamedParameter('name');
		Assert::same(':_1_name', $parameter->name());
		Assert::same('_1_name', $parameter->value());
	}
}
(new NamedParameterTest())->run();
