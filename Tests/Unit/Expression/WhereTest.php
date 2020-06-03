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
		$where = new Expression\Where('firstname', 'a');
		Assert::same('firstname = :_1_firstname', $where->sql());
		Assert::same(['_1_firstname' => 'a'], $where->parameters());
	}

	public function testTableColumn(): void {
		$where = new Expression\Where('users.firstname', 'a');
		Assert::same('users.firstname = :_1_users__firstname', $where->sql());
		Assert::same(['_1_users__firstname' => 'a'], $where->parameters());
	}
}
(new WhereTest())->run();
