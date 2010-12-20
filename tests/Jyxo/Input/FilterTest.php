<?php

/**
 * Jyxo Library
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * https://github.com/jyxo/php/blob/master/license.txt
 */

namespace Jyxo\Input;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Filter tests of package \Jyxo\Input
 *
 * @copyright Copyright (c) 2005-2010 Jyxo, s.r.o.
 * @license https://github.com/jyxo/php/blob/master/license.txt
 * @author Jan Pěček
 * @author Jaroslav Hanslík
 */
class FilterTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * String for testing multiple filters.
	 *
	 * @var string
	 */
	const TEST_STRING = ' tEst ';

	/**
	 * Desired filter chain result.
	 *
	 * @var string
	 */
	const TEST_STRING_RESULT = 'test';


	/**
	 * Tests Trim filter.
	 */
	public function testTrim()
	{
		$filter = new \Jyxo\Input\Filter\Trim();

		$this->filterTest($filter, '  test  ', 'test');

		$this->filterTest($filter,
			array('  test1', ' test2 '), array('test1', 'test2'));

		// Tests multidimensional array filtering
		$this->filterTest($filter,
			array(array(' ', ' ', array(' ')), ' '), array());

		$this->filterArrayTest($filter);
	}

	/**
	 * Tests LowerCase filter.
	 */
	public function testLowerCase()
	{
		$filter = new \Jyxo\Input\Filter\LowerCase();

		$this->filterTest($filter, 'tESt', 'test');

		$this->filterTest($filter,
			array('TEST1', 'tESt2'), array('test1', 'test2'));

		// Tests multidimensional array filtering
		$this->filterTest($filter,
			array('TEST1', array('tESt2', 'TeST')), array('test1', array('test2', 'test')));

		$this->filterArrayTest($filter);
	}

	/**
	 * Tests SanitizeUrl filter.
	 */
	public function testSanitizeUrl()
	{
		// In form: expected value, input value
		$tests = array(
			array(
				'http://www.jyxo.cz',
				'www.jyxo.cz'
			),
			array(
				'http://www.jyxo.cz',
				'http://www.jyxo.cz'
			),
			array(
				'https://www.jyxo.cz',
				'https://www.jyxo.cz'
			)
		);

		$filter = new \Jyxo\Input\Filter\SanitizeUrl();
		foreach ($tests as $test) {
			$result = $filter->filter($test[1]);
			$this->assertEquals(
				$test[0],
				$result
			);
		}

		$actual = 'www.jyxo.cz';
		$result = \Jyxo\Input\Filter\SanitizeUrl::filtrate($actual);
		$this->assertEquals('http://www.jyxo.cz', $result);
	}

	/**
	 * Common function for filter testing.
	 *
	 * @param \Jyxo\Input\FilterInterface $filter Filter instance
	 * @param mixed $var Input value
	 * @param mixed $expected Expected value
	 */
	private function filterTest(\Jyxo\Input\FilterInterface $filter, $var, $expected)
	{
		$result = $filter->filter($var);
		$this->assertEquals($expected, $result);
	}

	/**
	 * Array filtering test - uses an invalid value on input.
	 *
	 * @param \Jyxo\Input\FilterInterface $filter Filter instance
	 */
	private function filterArrayTest(\Jyxo\Input\FilterInterface $filter)
	{
		$var = array();
		$result = $filter->filter($var);
		$this->assertSame(array(), $result);

		$var = 'test';
		$result = $filter->filter($var);
		$this->assertSame('test', $result);
	}

}