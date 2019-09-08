<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Clause;

use Klapuch\Sql\Clause;
use Klapuch\Sql\Expression;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class InsertIntoTest extends Tester\TestCase {
	public function testNamedParameters(): void {
		$clause = new Clause\InsertInto('world', ['firstname' => 'a', 'lastname' => 'b']);
		Assert::same('INSERT INTO world (firstname, lastname) VALUES (:firstname, :lastname)', $clause->sql());
		Assert::same(['firstname' => 'a', 'lastname' => 'b'], $clause->parameters());
	}

	public function testArray(): void {
		$clause = new Clause\InsertInto('world', ['firstname' => new Expression\PgArray(['a', 'b'], 'text'), 'lastname' => 'c']);
		Assert::match('INSERT INTO world (firstname, lastname) VALUES (ARRAY[:pg_array__text__%d%__1, :pg_array__text__%d%__2]::text[], :lastname)', $clause->sql());
		[$key1, $key2, $key3] = array_keys($clause->parameters());
		Assert::same(['a', 'b', 'c'], array_values($clause->parameters()));
		Assert::match('pg_array__text__%d%__1', $key1);
		Assert::match('pg_array__text__%d%__2', $key2);
		Assert::match('lastname', $key3);
	}
}
(new InsertIntoTest())->run();
