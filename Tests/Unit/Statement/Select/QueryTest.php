<?php
declare(strict_types = 1);

namespace Klapuch\Sql\Unit\Statement\Select;

use Klapuch\Sql\Command;
use Klapuch\Sql\Expression;
use Klapuch\Sql\Statement;
use Tester;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
final class QueryTest extends Tester\TestCase {
	public function testBuilding(): void {
		Assert::same(
			'SELECT firstname FROM world JOIN people ON pid = id WHERE (1=1) GROUP BY firstname HAVING (count(*) > 0) ORDER BY firstname ASC LIMIT 10 OFFSET 2',
			(new Statement\Select\Query())
				->select(new Expression\Select(['firstname']))
				->from(new Expression\From(['world']))
				->join(new Command\Join('people', 'pid = id'))
				->where(new Expression\RawWhere('1=1'))
				->groupBy(new Expression\GroupBy('firstname'))
				->having(new Expression\Having('count(*) > 0'))
				->orderBy(new Expression\OrderBy(['firstname' => 'ASC']))
				->limit(10)
				->offset(2)
				->sql(),
		);
	}

	public function testBuildingWithRandomOrder(): void {
		Assert::same(
			'SELECT firstname FROM world JOIN people ON pid = id WHERE (1=1) GROUP BY firstname HAVING (count(*) > 0) ORDER BY firstname ASC LIMIT 10 OFFSET 2',
			(new Statement\Select\Query())
				->select(new Expression\Select(['firstname']))
				->where(new Expression\RawWhere('1=1'))
				->offset(2)
				->from(new Expression\From(['world']))
				->having(new Expression\Having('count(*) > 0'))
				->limit(10)
				->orderBy(new Expression\OrderBy(['firstname' => 'ASC']))
				->join(new Command\Join('people', 'pid = id'))
				->groupBy(new Expression\GroupBy('firstname'))
				->sql(),
		);
	}

	public function testPassingPreparedStatements(): void {
		$query = (new Statement\Select\Query())
			->select(new Expression\Select(['firstname', '?'], [666]))
			->from(new Expression\From(['world']))
			->join(new Command\Join('people', 'pid = id'))
			->where((new Expression\RawWhere('firstname = ?', ['no-one']))->and('length(lastname) > ?', [9]))
			->groupBy(new Expression\GroupBy('firstname'))
			->having(new Expression\Having('count(*) > ?', [10]))
			->limit(10)
			->offset(2);
		Assert::same(
			'SELECT firstname, ? FROM world JOIN people ON pid = id WHERE (firstname = ? AND length(lastname) > ?) GROUP BY firstname HAVING (count(*) > ?) LIMIT 10 OFFSET 2',
			$query->sql(),
		);
		Assert::same([666, 'no-one', 9, 10], $query->parameters());
	}

	public function testPassingPreparedStatementsForRandomOrder(): void {
		$query = (new Statement\Select\Query())
			->having(new Expression\Having('count(*) > ?', [10]))
			->from(new Expression\From(['world']))
			->select(new Expression\Select(['firstname', '?'], [666]))
			->where((new Expression\RawWhere('firstname = ?', ['no-one']))->and('length(lastname) > ?', [9]))
			->join(new Command\Join('people', 'pid = id'))
			->groupBy(new Expression\GroupBy('firstname'))
			->limit(10)
			->offset(2);
		Assert::same(
			'SELECT firstname, ? FROM world JOIN people ON pid = id WHERE (firstname = ? AND length(lastname) > ?) GROUP BY firstname HAVING (count(*) > ?) LIMIT 10 OFFSET 2',
			$query->sql(),
		);
		Assert::same([666, 'no-one', 9, 10], $query->parameters());
	}

	public function testMultipleWhereClausesAsAnd(): void {
		Assert::same(
			'SELECT firstname FROM world WHERE (1=1) AND (0=0)',
			(new Statement\Select\Query())
				->select(new Expression\Select(['firstname']))
				->from(new Expression\From(['world']))
				->where(new Expression\RawWhere('1=1'))
				->where(new Expression\RawWhere('0=0'))
				->sql(),
		);
	}

	public function testWhereClausesWithNesting(): void {
		Assert::same(
			'SELECT firstname FROM world WHERE (1=1) AND (0=0 OR 2=2) AND (3=3 AND 4=4)',
			(new Statement\Select\Query())
				->select(new Expression\Select(['firstname']))
				->from(new Expression\From(['world']))
				->where(new Expression\RawWhere('1=1'))
				->where((new Expression\RawWhere('0=0'))->or('2=2'))
				->where((new Expression\RawWhere('3=3'))->and('4=4'))
				->sql(),
		);
		Assert::same(
			'SELECT firstname FROM world WHERE (1=1) AND (0=0 OR 2=2) AND (3=3 AND 4=4) OR (3=3 AND 4=4)',
			(new Statement\Select\Query())
				->select(new Expression\Select(['firstname']))
				->from(new Expression\From(['world']))
				->where(new Expression\RawWhere('1=1'))
				->where((new Expression\RawWhere('0=0'))->or('2=2'))
				->where((new Expression\RawWhere('3=3'))->and('4=4'))
				->orWhere((new Expression\RawWhere('3=3'))->and('4=4'))
				->sql(),
		);
	}

	public function testMultipleWhereClausesWithOr(): void {
		Assert::same(
			'SELECT firstname FROM world WHERE (1=1) AND (0=0) OR (2=2)',
			(new Statement\Select\Query())
				->select(new Expression\Select(['firstname']))
				->from(new Expression\From(['world']))
				->where(new Expression\RawWhere('1=1'))
				->where(new Expression\RawWhere('0=0'))
				->orWhere(new Expression\RawWhere('2=2'))
				->sql(),
		);
	}

	public function testMultipleOrderByClauses(): void {
		Assert::same(
			'SELECT firstname FROM world ORDER BY firstname ASC, lastname DESC',
			(new Statement\Select\Query())
				->select(new Expression\Select(['firstname']))
				->from(new Expression\From(['world']))
				->orderBy(new Expression\OrderBy(['firstname']))
				->orderBy(new Expression\OrderBy(['lastname' => 'DESC']))
				->sql(),
		);
	}

	public function testMultipleNestedOrderByClauses(): void {
		Assert::same(
			'SELECT firstname FROM world ORDER BY firstname ASC, lastname DESC, id ASC',
			(new Statement\Select\Query())
				->select(new Expression\Select(['firstname']))
				->from(new Expression\From(['world']))
				->orderBy(new Expression\OrderBy(['firstname']))
				->orderBy(new Expression\OrderBy(['lastname' => 'DESC', 'id' => 'ASC']))
				->sql(),
		);
	}

	public function testMultipleGroupByClauses(): void {
		Assert::same(
			'SELECT firstname FROM world GROUP BY firstname, lastname',
			(new Statement\Select\Query())
				->select(new Expression\Select(['firstname']))
				->from(new Expression\From(['world']))
				->groupBy(new Expression\GroupBy('firstname'))
				->groupBy(new Expression\GroupBy('lastname'))
				->sql(),
		);
	}

	public function testDisallowingMultipleSelectClauses(): void {
		Assert::same(
			'SELECT lastname FROM world',
			(new Statement\Select\Query())
				->select(new Expression\Select(['firstname']))
				->select(new Expression\Select(['lastname']))
				->from(new Expression\From(['world']))
				->sql(),
		);
	}

	public function testMultipleJoins(): void {
		Assert::same(
			'SELECT firstname FROM world JOIN people ON pid = id LEFT JOIN rest ON rid = id',
			(new Statement\Select\Query())
				->select(new Expression\Select(['firstname']))
				->from(new Expression\From(['world']))
				->join(new Command\Join('people', 'pid = id'))
				->join(new Command\LeftJoin('rest', 'rid = id'))
				->sql(),
		);
	}

	public function testExistsWithResets(): void {
		$query = (new Statement\Select\Query())
			->select(new Expression\Select(['firstname', '?'], ['a']))
			->from(new Expression\From(['world']))
			->join(new Command\Join('people', 'pid = id'))
			->where(new Expression\RawWhere('1=?', ['b']))
			->groupBy(new Expression\GroupBy('firstname'))
			->having(new Expression\Having('count(*) > 0'))
			->orderBy(new Expression\OrderBy(['CASE WHEN ? THEN 0 ELSE 1 END' => 'ASC'], ['c']))
			->limit(10)
			->offset(2)
			->exists();
		Assert::same(
			'SELECT EXISTS (SELECT 1 FROM world JOIN people ON pid = id WHERE (1=?) GROUP BY firstname HAVING (count(*) > 0))',
			$query->sql(),
		);
		Assert::same(['b'], $query->parameters());
	}
}
(new QueryTest())->run();
