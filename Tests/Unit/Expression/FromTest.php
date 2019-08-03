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
final class FromTest extends Tester\TestCase {
	public function testSimpleTable(): void {
		Assert::same('world_or_what1', (new Expression\From(['world_or_what1']))->sql());
	}

	public function testInnerQuery(): void {
		Assert::same('(SELECT 1 FROM world) AS x', (new Expression\From(['(SELECT 1 FROM world) AS x']))->sql());
	}

	public function testMultipleTables(): void {
		Assert::same('world, people', (new Expression\From(['world', 'people']))->sql());
	}

	public function testKeyValueAsAliases(): void {
		Assert::same('world AS alias1', (new Expression\From(['alias1' => 'world']))->sql());
		Assert::same('world AS alias1, people AS alias2', (new Expression\From(['alias1' => 'world', 'alias2' => 'people']))->sql());
		Assert::same('world AS alias1, world AS alias2', (new Expression\From(['alias1' => 'world', 'alias2' => 'world']))->sql());
		Assert::same('world, world AS alias1', (new Expression\From(['world', 'alias1' => 'world']))->sql());
	}
}
(new FromTest())->run();
