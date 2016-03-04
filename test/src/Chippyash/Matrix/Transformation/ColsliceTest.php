<?php
namespace Chippyash\Test\Matrix\Transformation;
use Chippyash\Matrix\Transformation\Colslice;
use Chippyash\Matrix\Matrix;

/**
 * Description of ColsliceTest
 *
 */
class ColsliceTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected $testArray = array(array(1,2,3),array(1,2,3),array(1,2,3));

    protected function setUp()
    {
        $this->object = new Colslice();
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Second operand is not an array
     */
    public function testComputeThrowsExceptionIfSecondOperandNotAnArray()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, 'foo');
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Second operand does not contain col indicator
     */
    public function testComputeThrowsExceptionIfSecondOperandDoesNotContainCOlIndicator()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array());
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Col indicator out of bounds
     */
    public function testComputeThrowsExceptionIfColIndicatorLessThanOne()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(0));
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Col indicator out of bounds
     */
    public function testComputeThrowsExceptionIfColIndicatorGreaterThanColumns()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(4));
    }

    public function testComputeReturnsOneColIfNumcolsNotGiven()
    {
        $m = new Matrix($this->testArray);
        $this->assertEquals(1,$this->object->transform($m, array(1))->columns());
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Numcols out of bounds
     */
    public function testComputeThrowsExceptionIfNumcolsLessThanOne()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(1,0));
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Numcols out of bounds
     */
    public function testComputeThrowsExceptionIfNumcolsPlusColIndicatorGreaterThanColumns()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(1,4));
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix is not complete in row 2
     */
    public function testComputeThrowsExceptionIfFirstOperandIsIncompleteMatrix()
    {
        $m = new Matrix(array(array(1,2),array(1,2,3)));
        $this->object->transform($m, array(1));
    }


    public function testEmptyMatrixReturnsEmptyMatrix()
    {
        $mA = new Matrix(array());
        $test = $this->object->transform($mA, array(1));
        $this->assertTrue($test->is('Empty'));
    }

    public function testComputeReturnsCorrectResult()
    {
        $mA = new Matrix($this->testArray);
        $this->assertEquals(2,$this->object->transform($mA, array(1,2))->columns());
        $this->assertEquals(3,$this->object->transform($mA, array(1,3))->columns());
        $this->assertEquals(1,$this->object->transform($mA, array(2,1))->columns());
        $this->assertEquals(1,$this->object->transform($mA, array(3,1))->columns());
        $this->assertEquals(2,$this->object->transform($mA, array(2,2))->columns());
    }

}
