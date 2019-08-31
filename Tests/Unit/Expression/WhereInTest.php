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
final class WhereInTest extends Tester\TestCase {
	public function testNamedParameters(): void {
		$query = new Expression\WhereIn('age', [6, 20, 3]);
		Assert::same('age IN (:age__1, :age__2, :age__3)', $query->sql());
		Assert::same(['age__1' => 6, 'age__2' => 20, 'age__3' => 3], $query->parameters());
	}
}
(new WhereInTest())->run();