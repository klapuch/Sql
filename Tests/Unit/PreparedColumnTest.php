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
final class PreparedColumnTest extends Tester\TestCase {
	public function testTableColumnToPreparedColumns(): void {
		Assert::same('_users__name', (string) new Sql\PreparedColumn('users.name'));
		Assert::same('_users__name__something', (string) new Sql\PreparedColumn('users.name.something'));
	}

	public function testKeepingNormalColumns(): void {
		Assert::same('name', (string) new Sql\PreparedColumn('name'));
	}
}
(new PreparedColumnTest())->run();
