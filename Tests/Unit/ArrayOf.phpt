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

final class ArrayOf extends Tester\TestCase {
	public function testConstructedTypedArray() {
		$array = new Sql\ArrayOf(
			'foo[]',
			new Sql\Row(new Sql\Parameter('?'), new Sql\Parameter('?')),
			new Sql\Row(new Sql\Parameter('?'), new Sql\Parameter('?'))
		);
		Assert::same('ARRAY[ROW(?, ?), ROW(?, ?)]::foo[]', $array->expression());
	}
}

(new ArrayOf())->run();