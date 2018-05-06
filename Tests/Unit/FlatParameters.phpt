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

final class FlatParameters extends Tester\TestCase {
	public function testFlattenArray() {
		Assert::same(['person_name' => 'Dom', 'person_friend_number' => 0], (new Sql\FlatParameters(
			new class implements Sql\Parameters {
				public function bind(array $parameters): Sql\Parameters {

				}

				public function binds(): array {
					return [
						'person' => [
							'name' => 'Dom',
							'friend' => [
								'number' => 0,
							],
						]
					];
				}
			}
		))->binds());
	}

	public function testBindingWithFlatten() {
		Assert::same(['person_name' => 'Dom', 'person_friend_number' => 0, 'friends_cool' => true], (new Sql\FlatParameters(
			new Sql\UniqueParameters(
				[
					'person' => [
						'name' => 'Dom',
						'friend' => [
							'number' => 0,
						],
					]
				]
			)
		))->bind(['friends' => ['cool' => true]])->binds());
	}
}

(new FlatParameters())->run();