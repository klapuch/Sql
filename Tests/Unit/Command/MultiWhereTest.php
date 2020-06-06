<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Command;

use Klapuch\Sql\Command;
use Klapuch\Sql\Expression;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class MultiWhereTest extends Tester\TestCase {
	public function testConcatenate(): void {
		Assert::same(
			'WHERE (1=1) AND (2=2) OR (3=3) OR (4=4)',
			(new Command\MultiWhere([
				'AND' => [new Expression\RawWhere('1=1'), new Expression\RawWhere('2=2')],
				'OR' => [new Expression\RawWhere('3=3'), new Expression\RawWhere('4=4')],
			]))->sql(),
		);
	}
}
(new MultiWhereTest())->run();
