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

final class In extends Tester\TestCase {
	public function testAsPositional() {
		$in = new Sql\In('letters', ['a', 'b', 'c']);
		Assert::same('letters IN (?, ?, ?)', $in->sql());
		Assert::same(['a', 'b', 'c'], $in->parameters()->binds());
	}

	public function testAsNamedParameters() {
		$in = new Sql\In('letters', ['letters' => ['a', 'b', 'c']]);
		Assert::same('letters IN (:letters_0, :letters_1, :letters_2)', $in->sql());
		Assert::same([':letters_0' => 'a', ':letters_1' => 'b', ':letters_2' => 'c'], $in->parameters()->binds());
	}

	public function testAsNamedInnerParameters() {
		$in = new Sql\In('letters', ['letters' => ['x' => 'a', 'y' => 'b', 'z' => 'c']]);
		Assert::same('letters IN (:letters_x, :letters_y, :letters_z)', $in->sql());
		Assert::same([':letters_x' => 'a', ':letters_y' => 'b', ':letters_z' => 'c'], $in->parameters()->binds());
	}
}

(new In())->run();
