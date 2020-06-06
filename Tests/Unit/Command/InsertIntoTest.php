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
final class InsertIntoTest extends Tester\TestCase {
	public function testNamedParameters(): void {
		$command = new Command\InsertInto('world', ['firstname' => 'a', 'lastname' => 'b']);
		Assert::same('INSERT INTO world (firstname, lastname) VALUES (:_1_firstname, :_1_lastname)', $command->sql());
		Assert::same(['_1_firstname' => 'a', '_1_lastname' => 'b'], $command->parameters());
	}

	public function testArray(): void {
		$insertInto = new Command\InsertInto('world', ['firstname' => new Expression\PgArray(['a', 'b'], 'text'), 'lastname' => 'c']);
		Assert::match('INSERT INTO world (firstname, lastname) VALUES (ARRAY[:_2_pg_array__text__%d%__1, :_2_pg_array__text__%d%__2]::text[], :_2_lastname)', $insertInto->sql());
		[$key1, $key2, $key3] = array_keys($insertInto->parameters());
		Assert::same(['a', 'b', 'c'], array_values($insertInto->parameters()));
		Assert::match('_2_pg_array__text__%d%__1', $key1);
		Assert::match('_2_pg_array__text__%d%__2', $key2);
		Assert::match('_2_lastname', $key3);
	}
}
(new InsertIntoTest())->run();
