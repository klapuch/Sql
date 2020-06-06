<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Command;

use Klapuch\Sql\Command;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class JoinTest extends Tester\TestCase {
	public function testJoinFormat(): void {
		Assert::same('JOIN world ON id = pid', (new Command\Join('world', 'id = pid'))->sql());
		Assert::same('LEFT JOIN world ON id = pid', (new Command\LeftJoin('world', 'id = pid'))->sql());
	}
}
(new JoinTest())->run();
