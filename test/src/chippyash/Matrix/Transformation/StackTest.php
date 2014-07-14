<?php
namespace chippyash\Test\Matrix\Transformation;
use chippyash\Matrix\Transformation\Stack;
use chippyash\Matrix\Matrix;

/**
 *
 * @author akitson
 */
class StackTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new Stack();
    }


    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Parameter is not a matrix
     */
    public function testComputeThrowsExceptionIfSecondOperandIsNotAMatrix()
    {
        $mA = new Matrix(array(array(1,2),array(1,2)));
        $this->object->transform($mA, 'foo');
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage mA->cols != mB->cols
     */
    public function testComputeThrowsExceptionIfMatricesHaveDifferentColCount()
    {
        $mA = new Matrix(array(array(1,2),array(1,2)));
        $mB = new Matrix(array(array(1),array(1)));
        $this->object->transform($mA, $mB);
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix is not complete in row 2
     */
    public function testComputeThrowsExceptionIfFirstOperandIsIncompleteMatrix()
    {
        $mA = new Matrix(array(array(1,2),array(1)));
        $mB = new Matrix(array(array(1,2),array(1,2)));
        $this->object->transform($mA, $mB);
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix is not complete in row 2
     */
    public function testComputeThrowsExceptionIfSecondOperandIsIncompleteMatrix()
    {
        $mA = new Matrix(array(array(1,2),array(1,2)));
        $mB = new Matrix(array(array(1,2),array(1)));
        $this->object->transform($mA, $mB);
    }

    /**
     *
     */
    public function testEmptyMatrixReturnsEmptyMatrix()
    {
        $mA = new Matrix(array());
        $test = $this->object->transform($mA, $mA);
        $this->assertInstanceOf('chippyash\Matrix\Matrix', $test);
        $this->assertTrue($test->is('Empty'));
    }

    /**
     *
     */
    public function testComputeReturnsCorrectResult()
    {
        $mA = new Matrix([[1,2],[1,2]]);
        $mB = new Matrix([[3,4],[3,4]]);
        $result = [[1,2],[1,2],[3,4],[3,4]];
        $this->assertEquals($result, $this->object->transform($mA, $mB)->toArray());
    }

}
