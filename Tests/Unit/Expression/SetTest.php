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
final class SetTest extends Tester\TestCase {
	public function testMultiAssignment(): void {
		Assert::same('firstname = :firstname, lastname = :lastname', (new Expression\Set(['firstname' => 'a', 'lastname' => 'b']))->sql());
	}

	public function testKeepingNames(): void {
		Assert::same(['firstname' => 'a', 'lastname' => 'b'], (new Expression\Set(['firstname' => 'a', 'lastname' => 'b']))->parameters());
	}

	public function testPassingOnEmpty(): void {
		Assert::same('', (new Expression\Set([]))->sql());
		Assert::same([], (new Expression\Set([]))->parameters());
	}
}
(new SetTest())->run();
