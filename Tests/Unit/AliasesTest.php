<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit;

use Klapuch\Sql;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';
/**
 * @testCase
 */
final class AliasesTest extends Tester\TestCase {
	public function testKeyValueAsAliases(): void {
		Assert::same('world AS alias1', (string) new Sql\Aliases(['alias1' => 'world']));
		Assert::same('world AS alias1, people AS alias2', (string) new Sql\Aliases(['alias1' => 'world', 'alias2' => 'people']));
		Assert::same('world AS alias1, world AS alias2', (string) new Sql\Aliases(['alias1' => 'world', 'alias2' => 'world']));
		Assert::same('world, world AS alias1', (string) new Sql\Aliases(['world', 'alias1' => 'world']));
	}
}
(new AliasesTest())->run();
