<?php
namespace Chippyash\Test\Matrix\Transformation;
use Chippyash\Matrix\Transformation\Concatenate;
use Chippyash\Matrix\Matrix;

/**
 *
 * @author akitson
 */
class ConcatenateTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new Concatenate();
    }


    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Parameter is not a matrix
     */
    public function testComputeThrowsExceptionIfSecondOperandIsNotAMatrix()
    {
        $mA = new Matrix(array(array(1,2),array(1,2)));
        $this->object->transform($mA, 'foo');
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage mA->rows != mB->rows
     */
    public function testComputeThrowsExceptionIfMatricesHaveDifferentRowCount()
    {
        $mA = new Matrix(array(array(1,2),array(1,2)));
        $mB = new Matrix(array(array(1,2),array(1,2),array(1,2)));
        $this->object->transform($mA, $mB);
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix is not complete in row 2
     */
    public function testComputeThrowsExceptionIfFirstOperandIsIncompleteMatrix()
    {
        $mA = new Matrix(array(array(1,2),array(1)));
        $mB = new Matrix(array(array(1,2),array(1,2)));
        $this->object->transform($mA, $mB);
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
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
        $this->assertInstanceOf('Chippyash\Matrix\Matrix', $test);
        $this->assertTrue($test->is('Empty'));
    }

    /**
     *
     */
    public function testComputeReturnsCorrectResult()
    {
        $mA = new Matrix(array(array(1,2),array(1,2)));
        $mB = new Matrix(array(array(3,4),array(3,4)));
        $result = array(array(1,2,3,4),array(1,2,3,4));
        $this->assertEquals($result, $this->object->transform($mA, $mB)->toArray());
    }

}
