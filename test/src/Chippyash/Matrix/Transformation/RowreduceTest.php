<?php
namespace Chippyash\Test\Matrix\Transformation;
use Chippyash\Matrix\Transformation\Rowreduce;
use Chippyash\Matrix\Matrix;

/**
 * Description of RowreduceTest
 *
 */
class RowreduceTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected $testArray = array(array(1,2),array(3,4),array(5,6));

    protected function setUp()
    {
        $this->object = new Rowreduce();
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Second operand is not an array
     */
    public function testTransformThrowsExceptionIfSecondOperandNotAnArray()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, 'foo');
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Second operand does not contain row indicator
     */
    public function testTransformThrowsExceptionIfSecondOperandDoesNotContainRowIndicator()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array());
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Row indicator out of bounds
     */
    public function testTransformThrowsExceptionIfRowIndicatorLessThanOne()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(0));
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Row indicator out of bounds
     */
    public function testTransformThrowsExceptionIfRowIndicatorGreaterThanRows()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(4));
    }

    public function testTransformReturnsMatrixReducedByOneRowIfNumrowsNotGiven()
    {
        $m = new Matrix($this->testArray);
        $this->assertEquals(
                array(array(3,4),array(5,6))
                ,$this->object->transform($m, array(1))->toArray()
                );
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Numrows out of bounds
     */
    public function testTransformThrowsExceptionIfNumrowsLessThanOne()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(1,0));
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Numrows out of bounds
     */
    public function testTransformThrowsExceptionIfNumrowsPlusRowIndicatorGreaterThanRows()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(1,4));
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix is not complete in row 2
     */
    public function testTransformThrowsExceptionIfFirstOperandIsIncompleteMatrix()
    {
        $m = new Matrix(array(array(1,2),array(1)));
        $this->object->transform($m, array(1));
    }

    /**
     * @covers Chippyash\Matrix\Transformation\Rowreduce::transform()
     */
    public function testEmptyMatrixReturnsEmptyMatrix()
    {
        $mA = new Matrix(array());
        $test = $this->object->transform($mA, array(1));
        $this->assertTrue($test->is('Empty'));
    }

    /**
     * @covers Chippyash\Matrix\Transformation\Rowreduce::transform()
     */
    public function testTransformReturnsCorrectResult()
    {
        $mA = new Matrix($this->testArray);
        $this->assertEquals(
                array(array(5,6))
                ,$this->object->transform($mA, array(1,2))->toArray());
        $this->assertEquals(
                array(array()),
                $this->object->transform($mA, array(1,3))->toArray());
        $this->assertEquals(
                array(array(1,2),array(5,6)),
                $this->object->transform($mA, array(2,1))->toArray());
        $this->assertEquals(
                array(array(1,2),array(3,4)),
                $this->object->transform($mA, array(3,1))->toArray());
        $this->assertEquals(
                array(array(1,2)),
                $this->object->transform($mA, array(2,2))->toArray());
    }

}
