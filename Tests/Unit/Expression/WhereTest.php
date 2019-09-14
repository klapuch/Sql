<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Expression;

use Klapuch\Sql\Expression;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class WhereTest extends Tester\TestCase {
	public function testAutoPreparedParameter(): void {
		Assert::same('firstname = :firstname', (new Expression\Where('firstname', 'a'))->sql());
		Assert::same(['firstname' => 'a'], (new Expression\Where('firstname', 'a'))->parameters());
	}

	public function testTableColumn(): void {
		Assert::same('users.firstname = :_users__firstname', (new Expression\Where('users.firstname', 'a'))->sql());
		Assert::same(['_users__firstname' => 'a'], (new Expression\Where('users.firstname', 'a'))->parameters());
	}
}
(new WhereTest())->run();
