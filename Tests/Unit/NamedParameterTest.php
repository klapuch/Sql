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
		Assert::same('_1_users__name', (string) new Sql\NamedParameter('users.name'));
		Assert::same('_2_users__name__something', (string) new Sql\NamedParameter('users.name.something'));
	}

	public function testKeepingNormalColumns(): void {
		Assert::same('_1_name', (string) new Sql\NamedParameter('name'));
	}
}
(new NamedParameterTest())->run();
