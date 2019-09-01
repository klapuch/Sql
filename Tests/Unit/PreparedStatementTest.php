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
final class PreparedStatementTest extends Tester\TestCase {
	public function testKeepingKeys(): void {
		$statement = new Sql\PreparedStatement(['firstname' => ['a', 'b'], 'lastname' => 'c']);
		Assert::same(['firstname' => ['a', 'b'], 'lastname' => 'c'], $statement->parameters());
		Assert::same(['firstname' => ':firstname', 'lastname' => ':lastname'], $statement->sql());
	}

	public function testGeneratingNamedSqlForExpression(): void {
		$statement = new Sql\PreparedStatement(['firstname' => new Sql\Expression\PgArray(['a', 'b'], 'text'), 'lastname' => 'c']);
		Assert::same(['firstname' => 'ARRAY[:firstname__1, :firstname__2]::text[]', 'lastname' => ':lastname'], $statement->sql());
		Assert::same(['firstname__1' => 'a', 'firstname__2' => 'b', 'lastname' => 'c'], $statement->parameters());
	}

	public function testMultiCall(): void {
		$statement = new Sql\PreparedStatement(['firstname' => new Sql\Expression\PgArray(['a', 'b'], 'text'), 'lastname' => 'c']);
		Assert::same(['firstname' => 'ARRAY[:firstname__1, :firstname__2]::text[]', 'lastname' => ':lastname'], $statement->sql());
		Assert::same(['firstname' => 'ARRAY[:firstname__1, :firstname__2]::text[]', 'lastname' => ':lastname'], $statement->sql());
		Assert::same(['firstname__1' => 'a', 'firstname__2' => 'b', 'lastname' => 'c'], $statement->parameters());
		Assert::same(['firstname__1' => 'a', 'firstname__2' => 'b', 'lastname' => 'c'], $statement->parameters());
	}

	public function testEmpty(): void {
		$statement = new Sql\PreparedStatement([]);
		Assert::same([], $statement->sql());
		Assert::same([], $statement->parameters());
	}
}
(new PreparedStatementTest())->run();
