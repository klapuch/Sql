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
final class PgArrayTest extends Tester\TestCase {
	public function testPreparedArray(): void {
		Assert::same('ARRAY[?, ?, ?]::text[]', (new Expression\PgArray(['a', 'b', 'c'], 'text'))->sql());
		Assert::same(['a', 'b', 'c'], (new Expression\PgArray(['a', 'b', 'c'], 'text'))->parameters());
		Assert::same('ARRAY[]::text[]', (new Expression\PgArray([], 'text'))->sql());
		Assert::same([], (new Expression\PgArray([], 'text'))->parameters());
	}
}
(new PgArrayTest())->run();
