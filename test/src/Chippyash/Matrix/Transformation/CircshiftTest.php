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
use Chippyash\Matrix\Transformation\Circshift;

class CircshiftTest extends \PHPUnit_Framework_TestCase
{
    /**
     * System Under Test
     * @var Circshift
     */
    protected $sut;

    /**
     * @var Matrix
     */
    protected $mA;

    protected function setUp()
    {
        $this->sut = new Circshift();
        $this->mA = new Matrix(array(
            array(1, 2, 3),
            array(4, 5, 6),
            array(7, 8, 9)
        ));
    }

    public function testYouCanShiftASingleColumnToTheRight()
    {
        $test = new Matrix(array(
            array(3, 1, 2),
            array(6, 4, 5),
            array(9, 7, 8)
        ));

        $this->assertEquals($test->toArray(), $this->sut->transform($this->mA, 1)->toArray());
    }

    public function testYouCanShiftAMultipleColumnsToTheRight()
    {
        $test = new Matrix(array(
            array(2, 3, 1),
            array(5, 6, 4),
            array(8, 9, 7)
        ));

        $this->assertEquals($test->toArray(), $this->sut->transform($this->mA, 2)->toArray());
    }

    public function testYouCanShiftASingleColumnToTheLeft()
    {
        $test = new Matrix(array(
            array(2, 3, 1),
            array(5, 6, 4),
            array(8, 9, 7)
        ));

        $this->assertEquals($test->toArray(), $this->sut->transform($this->mA, -1)->toArray());
    }

    public function testYouCanShiftAMultipleColumnsToTheLeft()
    {
        $test = new Matrix(array(
            array(3, 1, 2),
            array(6, 4, 5),
            array(9, 7, 8)
        ));

        $this->assertEquals($test->toArray(), $this->sut->transform($this->mA, -2)->toArray());
    }

    public function testANullShiftParameterWillDefaultToSingleRightShift()
    {
        $test = new Matrix(array(
            array(3, 1, 2),
            array(6, 4, 5),
            array(9, 7, 8)
        ));

        $this->assertEquals($test->toArray(), $this->sut->transform($this->mA)->toArray());

    }

    public function testShiftingAnEmptyMatrixWillReturnAnEmptyMatrix()
    {
        $test = new Matrix(array());
        $this->assertEquals($test->toArray(), $this->sut->transform(new Matrix(array()))->toArray());
    }

    public function testShiftingAnSingleItemMatrixWillReturnACloneOfTheMatrix()
    {
        $test = new Matrix(array(1));
        $this->assertEquals($test->toArray(), $this->sut->transform($test)->toArray());
    }

    public function testAZeroShiftParameterWillReturnACloneOfTheShiftedMatrix()
    {
        $this->assertEquals($this->mA->toArray(), $this->sut->transform($this->mA, 0)->toArray());
    }

    public function testShiftingAColumnVectorWillReturnACloneOfTheOriginalVector()
    {
        $mA = new Matrix([[1], [2], [3]]);
        $this->assertEquals($mA->toArray(), $this->sut->transform($mA)->toArray());
    }
}
