<?php
namespace chippyash\Test\Matrix\Transformation;
use chippyash\Matrix\Transformation\Cofactor;
use chippyash\Matrix\Matrix;

/**
 * Description of CofactorTest
 *
 */
class CofactorTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected $testArray = array(array(1,2,3),array(4,5,6),array(7,8,9));

    protected function setUp()
    {
        $this->object = new Cofactor();
    }

    public function testEmptyMatrixReturnsEmptyMatrix()
    {
        $mA = new Matrix(array());
        $test = $this->object->transform($mA, array());
        $this->assertTrue($test->is('Empty'));
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
     * @expectedExceptionMessage Second operand does not contain row and column
     */
    public function testTransformThrowsExceptionIfSecondOperandDoesNotContainRowAndColIndicator()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array());
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Row indicator out of bounds
     */
    public function testTransformThrowsExceptionIfRowIndicatorLessThanOne()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(0,1));
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Row indicator out of bounds
     */
    public function testTransformThrowsExceptionIfRowIndicatorGreaterThanRows()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(4,1));
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Col indicator out of bounds
     */
    public function testTransformThrowsExceptionIfColIndicatorLessThanOne()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(1,0));
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Col indicator out of bounds
     */
    public function testTransformThrowsExceptionIfColIndicatorGreaterThanColumns()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, array(1,4));
    }

    public function testTransformReturnsCorrectResult()
    {
        $mA = new Matrix($this->testArray);
        $this->assertEquals(
                array(array(5,6),array(8,9)),
                $this->object->transform($mA, array(1,1))->toArray());
        $this->assertEquals(
                array(array(1,3),array(7,9)),
                $this->object->transform($mA, array(2,2))->toArray());
        $this->assertEquals(
                array(array(1,2),array(4,5)),
                $this->object->transform($mA, array(3,3))->toArray());
        $this->assertEquals(
                array(array(4,6),array(7,9)),
                $this->object->transform($mA, array(1,2))->toArray());
    }

}
