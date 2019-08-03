<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Clause;

use Klapuch\Sql\Clause;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
final class InsertIntoTest extends Tester\TestCase {
	public function testNamedParameters(): void {
		Assert::same('INSERT INTO world (firstname, lastname) VALUES (:firstname, :lastname)', (new Clause\InsertInto('world', ['firstname' => 'a', 'lastname' => 'b']))->sql());
		Assert::same(['firstname' => 'a', 'lastname' => 'b'], (new Clause\InsertInto('world', ['firstname' => 'a', 'lastname' => 'b']))->parameters());
	}
}
(new InsertIntoTest())->run();
