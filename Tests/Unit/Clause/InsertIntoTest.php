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
		$clause = new Clause\InsertInto('world', ['firstname' => new Expression\PgArray(['a', 'b']), 'lastname' => 'c']);
		Assert::same('INSERT INTO world (firstname, lastname) VALUES (ARRAY[:firstname__1, :firstname__2], :lastname)', $clause->sql());
		Assert::same(['firstname__1' => 'a', 'firstname__2' => 'b', 'lastname' => 'c'], $clause->parameters());
	}
}
(new InsertIntoTest())->run();
