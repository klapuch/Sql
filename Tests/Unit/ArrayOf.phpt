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
	public function testConstructedArray() {
		$array = new Sql\ArrayOf(new Sql\Row([1, 'a']), new Sql\Row([2, 'b']));
		Assert::same('ARRAY[ROW(?, ?), ROW(?, ?)]', $array->sql());
		Assert::same([1, 'a', 2, 'b'], $array->parameters()->binds());
	}

	/**
	 * @throws \UnexpectedValueException Keys can not be duplicated: number
	 */
	public function testThrowingOnRepeatedParameter() {
		$array = new Sql\ArrayOf(new Sql\Row(['number' => 1, 'letter' => 'a']), new Sql\Row(['number' => 2, 'letter2' => 'b']));
		Assert::same([1, 'a', 2, 'b'], $array->parameters()->binds());
	}
}

(new ArrayOf())->run();