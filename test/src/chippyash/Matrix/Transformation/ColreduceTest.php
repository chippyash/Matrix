<?php
namespace chippyash\Test\Matrix\Transformation;
use chippyash\Matrix\Transformation\Colreduce;
use chippyash\Matrix\Matrix;

/**
 * Description of ColreduceTest
 *
 */
class ColreduceTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected $testArray = array(array(1,2,3),array(1,2,3),array(1,2,3));

    protected function setUp()
    {
        $this->object = new Colreduce();
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Second operand is not an array
     */
    public function testTransformThrowsExceptionIfSecondOperandNotAnArray()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, 'foo');
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Second operand does not contain col indicator
     */
    public function testTransformThrowsExceptionIfSecondOperandDoesNotContainCOlIndicator()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array());
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Col indicator out of bounds
     */
    public function testTransformThrowsExceptionIfColIndicatorLessThanOne()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(0));
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Col indicator out of bounds
     */
    public function testTransformThrowsExceptionIfColIndicatorGreaterThanColumns()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(4));
    }

    /**
     * @covers chippyash\Matrix\Transformation\Colreduce::transform()
     */
    public function testTransformReducesByOneColumnIfNumcolsNotGiven()
    {
        $m = new Matrix($this->testArray);
        $this->assertEquals(2,$this->object->transform($m, array(1))->columns());
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Numcols out of bounds
     */
    public function testTransformThrowsExceptionIfNumcolsLessThanOne()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(1,0));
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Numcols out of bounds
     */
    public function testTransformThrowsExceptionIfNumcolsPlusColIndicatorGreaterThanColumns()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(1,4));
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix is not complete in row 2
     */
    public function testTransformThrowsExceptionIfFirstOperandIsIncompleteMatrix()
    {
        $m = new Matrix(array(array(1,2),array(1,2,3)));
        $this->object->transform($m, array(1));
    }

    /**
     * @covers chippyash\Matrix\Transformation\Colreduce::transform()
     */
    public function testEmptyMatrixReturnsEmptyMatrix()
    {
        $mA = new Matrix(array());
        $test = $this->object->transform($mA, array(1));
        $this->assertTrue($test->is('Empty'));
    }

    /**
     * @covers chippyash\Matrix\Transformation\Colreduce::transform()
     */
    public function testTransformReturnsCorrectResult()
    {
        $mA = new Matrix($this->testArray);
        $this->assertEquals(
                array(array(3),array(3),array(3)),
                $this->object->transform($mA, array(1,2))->toArray());
        $this->assertEquals(
                array(array()),
                $this->object->transform($mA, array(1,3))->toArray());
        $this->assertEquals(
                array(array(1,3),array(1,3),array(1,3)),
                $this->object->transform($mA, array(2,1))->toArray());
        $this->assertEquals(
                array(array(1,2),array(1,2),array(1,2)),
                $this->object->transform($mA, array(3,1))->toArray());
        $this->assertEquals(
                array(array(1),array(1),array(1)),
                $this->object->transform($mA, array(2,2))->toArray());
    }

}
