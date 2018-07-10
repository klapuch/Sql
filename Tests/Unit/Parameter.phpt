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

final class Parameter extends Tester\TestCase {
	/**
	 * @dataProvider invalidParameters
	 */
	public function testThrowingOnInvalidParameters(string $parameter) {
		Assert::exception(function () use ($parameter) {
			(new Sql\Parameter($parameter))->expression();
		}, \UnexpectedValueException::class, sprintf('Parameter "%s" is invalid', $parameter));
	}

	public function testPassingOnValidPreparedParameter() {
		Assert::same('?', (new Sql\Parameter('?'))->expression());
		Assert::same(':foo', (new Sql\Parameter(':foo'))->expression());
	}

	protected function invalidParameters(): array {
		return [
			['??'],
			['?:'],
			['a'],
			['a?'],
			['a:'],
			['SELECT 1'],
		];
	}
}

(new Parameter())->run();