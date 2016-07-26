<?php
/**
 * Matrix
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2016, UK
 * @license BSD 3 Clause See LICENSE.md
 */

namespace Chippyash\Test\Matrix\Transformation;

use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Transformation\Shift;

class ShiftTest extends \PHPUnit_Framework_TestCase
{
    /**
     * System Under Test
     * @var Shift
     */
    protected $sut;

    /**
     * @var Matrix
     */
    protected $mA;

    protected function setUp()
    {
        $this->sut = new Shift();
        $this->mA = new Matrix(array(
            array(1, 2, 3),
            array(4, 5, 6),
            array(7, 8, 9)
        ));
    }

    public function testYouCanShiftASingleColumnToTheRight()
    {
        $test = new Matrix(array(
            array(null, 1, 2),
            array(null, 4, 5),
            array(null, 7, 8)
        ));

        $this->assertEquals($test->toArray(), $this->sut->transform($this->mA, [1])->toArray());
    }

    public function testYouCanShiftAMultipleColumnsToTheRight()
    {
        $test = new Matrix(array(
            array(null, null, 1),
            array(null, null, 4),
            array(null, null, 7)
        ));

        $this->assertEquals($test->toArray(), $this->sut->transform($this->mA, [2])->toArray());
    }

    public function testYouCanShiftASingleColumnToTheLeft()
    {
        $test = new Matrix(array(
            array(2, 3, null),
            array(5, 6, null),
            array(8, 9, null)
        ));

        $this->assertEquals($test->toArray(), $this->sut->transform($this->mA, [-1])->toArray());
    }

    public function testYouCanShiftAMultipleColumnsToTheLeft()
    {
        $test = new Matrix(array(
            array(3, null, null),
            array(6, null, null),
            array(9, null, null)
        ));

        $this->assertEquals($test->toArray(), $this->sut->transform($this->mA, [-2])->toArray());
    }

    public function testANullShiftParameterWillDefaultToSingleRightShift()
    {
        $test = new Matrix(array(
            array(null, 1, 2),
            array(null, 4, 5),
            array(null, 7, 8)
        ));

        $this->assertEquals($test->toArray(), $this->sut->transform($this->mA)->toArray());

    }

    public function testShiftingAnEmptyMatrixWillReturnAnEmptyMatrix()
    {
        $test = new Matrix(array());
        $this->assertEquals($test->toArray(), $this->sut->transform(new Matrix(array()))->toArray());
    }

    public function testShiftingAnSingleItemMatrixWillReturnAnEmptyMatrix()
    {
        $test = new Matrix(array(1));
        $this->assertTrue($this->sut->transform($test)->is('empty'));
    }

    public function testAZeroShiftParameterWillReturnACloneOfTheShiftedMatrix()
    {
        $this->assertEquals($this->mA->toArray(), $this->sut->transform($this->mA, [0])->toArray());
    }

    public function testShiftingAColumnVectorWillReturnAReplacedVector()
    {
        $mA = new Matrix([[1], [2], [3]]);
        $test = new Matrix([[null],[null],[null]]);
        $this->assertEquals($test->toArray(), $this->sut->transform($mA)->toArray());
    }

    public function testYouCanSupplyAReplacementValue()
    {
        $test = new Matrix(array(
            array('foo', 1, 2),
            array('foo', 4, 5),
            array('foo', 7, 8)
        ));

        $this->assertEquals($test->toArray(), $this->sut->transform($this->mA, [null, 'foo'])->toArray());
    }
}
