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
final class CustomCommandTest extends Tester\TestCase {
	public function testFilteringEmpty(): void {
		Assert::same(
			'',
			(new Command\CustomCommand(
				'GROUP BY',
				new Expression\GroupBy(''),
			))->sql(),
		);
	}

	public function testConcatenate(): void {
		Assert::same(
			'GROUP BY firstname',
			(new Command\CustomCommand(
				'GROUP BY',
				new Expression\GroupBy('firstname'),
			))->sql(),
		);
	}
}
(new CustomCommandTest())->run();
