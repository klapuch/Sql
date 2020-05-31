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
		Assert::match('ARRAY[:pg_array__text__%d%__1, :pg_array__text__%d%__2, :pg_array__text__%d%__3]::text[]', (new Expression\PgArray(['a', 'b', 'c'], 'text'))->sql());
		[$key1, $key2, $key3] = array_keys((new Expression\PgArray(['a', 'b', 'c'], 'text'))->parameters());
		Assert::match('pg_array__text__%d%__1', $key1);
		Assert::match('pg_array__text__%d%__2', $key2);
		Assert::match('pg_array__text__%d%__3', $key3);
	}

	public function testMultipleArrayWithDifferentIdentifier(): void {
		$a = new Expression\PgArray(['a', 'b', 'c'], 'text');
		$b = new Expression\PgArray(['a', 'b', 'c'], 'text');
		Assert::notSame($a->sql(), $b->sql());
	}

	public function testEmpty(): void {
		Assert::same('ARRAY[]::text[]', (new Expression\PgArray([], 'text'))->sql());
		Assert::same([], (new Expression\PgArray([], 'text'))->parameters());
	}
}
(new PgArrayTest())->run();
