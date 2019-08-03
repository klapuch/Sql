<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Clause;

use Klapuch\Sql\Clause;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class JoinTest extends Tester\TestCase {
	public function testJoinFormat(): void {
		Assert::same('JOIN world ON id = pid', (new Clause\Join('world', 'id = pid'))->sql());
		Assert::same('LEFT JOIN world ON id = pid', (new Clause\LeftJoin('world', 'id = pid'))->sql());
	}
}
(new JoinTest())->run();
