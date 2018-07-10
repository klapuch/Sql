<?php
declare(strict_types = 1);

/**
 * @testCase
 * @phpVersion > 7.2
 */
namespace Klapuch\Sql\Unit;

use Klapuch\Sql;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class Point extends Tester\TestCase {
	public function testConstructingValuesInRow() {
		$row = new Sql\Point(new Sql\Parameter(':x'), new Sql\Parameter(':y'));
		Assert::same('POINT(:x, :y)', $row->expression());
	}
}

(new Point())->run();