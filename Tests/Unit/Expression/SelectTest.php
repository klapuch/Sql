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
final class SelectTest extends Tester\TestCase {
	public function testSingleColumn(): void {
		Assert::same('foo', (new Expression\Select(['foo']))->sql());
	}

	public function testMultipleColumns(): void {
		Assert::same('foo, bar', (new Expression\Select(['foo', 'bar']))->sql());
	}

	public function testKeyValueAsAliases(): void {
		Assert::same('firstname AS alias1', (new Expression\Select(['alias1' => 'firstname']))->sql());
		Assert::same('firstname AS alias1, lastname AS alias2', (new Expression\Select(['alias1' => 'firstname', 'alias2' => 'lastname']))->sql());
		Assert::same('firstname AS alias1, firstname AS alias2', (new Expression\Select(['alias1' => 'firstname', 'alias2' => 'firstname']))->sql());
		Assert::same('firstname, firstname AS alias1', (new Expression\Select(['firstname', 'alias1' => 'firstname']))->sql());
	}
}
(new SelectTest())->run();
