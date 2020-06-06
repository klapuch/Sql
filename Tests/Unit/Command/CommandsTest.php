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
final class CommandsTest extends Tester\TestCase {
	public function testFilteringEmpty(): void {
		Assert::same(
			'',
			(new Command\Commands(
				new Command\GroupBy(),
				new Command\Having(new Expression\EmptyExpression()),
			))->sql(),
		);
		Assert::same(
			'GROUP BY a HAVING (b)',
			(new Command\Commands(
				new Command\GroupBy(new Expression\GroupBy('a')),
				new Command\Having(new Expression\EmptyExpression()),
				new Command\Having(new Expression\Having('b')),
			))->sql(),
		);
	}

	public function testAllowingEmptyParameters(): void {
		Assert::same(
			[],
			(new Command\Commands())->parameters(),
		);
	}
}
(new CommandsTest())->run();
