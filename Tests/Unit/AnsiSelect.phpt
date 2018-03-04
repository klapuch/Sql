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

final class AnsiSelect extends Tester\TestCase {
	public function testAllClauses() {
		$sql = (new Sql\AnsiSelect(['firstname', 'lastname', 'COUNT(*)']))
			->from(['person', 'world'])
			->join('LEFT', 'dungeon', 'dungeon.id = person.dungeon_id')
			->join('INNER', 'farts', 'farts.id = dungeon.dungeon_id')
			->where('age > 20')
			->where('age > 40')
			->orWhere('age > 50')
			->groupBy(['firstname', 'lastname'])
			->having('COUNT(firstname) > 10')
			->orderBy(['firstname' => 'DESC', 'lastname' => 'ASC'])
			->limit(10)
			->offset(100)
			->sql();
		Assert::same('SELECT firstname, lastname, COUNT(*) FROM person, world LEFT JOIN dungeon ON dungeon.id = person.dungeon_id INNER JOIN farts ON farts.id = dungeon.dungeon_id WHERE age > 20 AND age > 40 OR age > 50 GROUP BY firstname, lastname HAVING COUNT(firstname) > 10 ORDER BY firstname DESC, lastname ASC LIMIT 10 OFFSET 100', $sql);
	}
}

(new AnsiSelect())->run();