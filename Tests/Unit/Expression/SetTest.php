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

	public function testArray(): void {
		$expression = new Expression\Set(['firstname' => new Expression\PgArray(['a', 'b'], 'text'), 'lastname' => 'c']);
		Assert::match('firstname = ARRAY[:pg_array__text__%d%__1, :pg_array__text__%d%__2]::text[], lastname = :lastname', $expression->sql());
		[$key1, $key2, $key3] = array_keys($expression->parameters());
		Assert::same(['a', 'b', 'c'], array_values($expression->parameters()));
		Assert::match('pg_array__text__%d%__1', $key1);
		Assert::match('pg_array__text__%d%__2', $key2);
		Assert::match('lastname', $key3);
	}

	public function testTableColumn(): void {
		$expression = new Expression\Set(['users.firstname' => 'a', 'users.lastname' => 'b']);
		Assert::same(['_users__firstname' => 'a', '_users__lastname' => 'b'], $expression->parameters());
		Assert::same('users.firstname = :_users__firstname, users.lastname = :_users__lastname', $expression->sql());
	}

	public function testPassingOnEmpty(): void {
		Assert::same('', (new Expression\Set([]))->sql());
		Assert::same([], (new Expression\Set([]))->parameters());
	}
}
(new SetTest())->run();
