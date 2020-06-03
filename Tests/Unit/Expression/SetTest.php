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
		$set = new Expression\Set(['firstname' => 'a', 'lastname' => 'b']);
		Assert::same('firstname = :_1_firstname, lastname = :_1_lastname', $set->sql());
		Assert::same(['_1_firstname' => 'a', '_1_lastname' => 'b'], $set->parameters());
	}

	public function testArray(): void {
		$set = new Expression\Set(['firstname' => new Expression\PgArray(['a', 'b'], 'text'), 'lastname' => 'c']);
		Assert::match('firstname = ARRAY[:_2_pg_array__text__%d%__1, :_2_pg_array__text__%d%__2]::text[], lastname = :_2_lastname', $set->sql());
		[$key1, $key2, $key3] = array_keys($set->parameters());
		Assert::same(['a', 'b', 'c'], array_values($set->parameters()));
		Assert::match('_2_pg_array__text__%d%__1', $key1);
		Assert::match('_2_pg_array__text__%d%__2', $key2);
		Assert::match('_2_lastname', $key3);
	}

	public function testTableColumn(): void {
		$expression = new Expression\Set(['users.firstname' => 'a', 'users.lastname' => 'b']);
		Assert::same(['_1_users__firstname' => 'a', '_1_users__lastname' => 'b'], $expression->parameters());
		Assert::same('users.firstname = :_1_users__firstname, users.lastname = :_1_users__lastname', $expression->sql());
	}

	public function testPassingOnEmpty(): void {
		Assert::same('', (new Expression\Set([]))->sql());
		Assert::same([], (new Expression\Set([]))->parameters());
	}
}
(new SetTest())->run();
