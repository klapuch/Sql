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

final class Row extends Tester\TestCase {
	public function testConstructedRowFromPositionalParameters() {
		$row = new Sql\Row(['a', 1]);
		Assert::same('ROW(?, ?)', $row->sql());
		Assert::same(['a', 1], $row->parameters()->binds());
	}

	public function testConstructedRowFromNamedParameters() {
		$row = new Sql\Row(['letter' => 'a', 'number' => 1]);
		Assert::same('ROW(:letter, :number)', $row->sql());
		Assert::same(['letter' => 'a', 'number' => 1], $row->parameters()->binds());
	}
}

(new Row())->run();