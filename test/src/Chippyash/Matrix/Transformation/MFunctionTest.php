<?php
namespace Chippyash\Test\Matrix\Transformation;
use Chippyash\Matrix\Transformation\MFunction;
use Chippyash\Matrix\Matrix;

/**
 *
 * @author akitson
 */
class MFunctionTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new MFunction();
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\NotCompleteMatrixException
     * @expectedExceptionMessage Matrix is not complete in row 2
     */
    public function testComputeThrowsExceptionIfFirstOperandIsIncompleteMatrix()
    {
        $m = new Matrix(array(array(1,2),array(1)));
        $this->object->transform($m, function(){});
    }

    public function testEmptyMatrixReturnsEmptyMatrix()
    {
        $mA = new Matrix(array());
        $test = $this->object->transform($mA, function(){});
        $this->assertInstanceOf('Chippyash\Matrix\Matrix', $test);
        $this->assertTrue($test->is('Empty'));
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Function parameter is not callable
     */
    public function testSecondParameterToComputeIsNotOptional()
    {
        $mA = new Matrix(array(array(1)));
        $this->object->transform($mA);
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Function parameter is not callable
     */
    public function testSecondParameterToComputeMustBeCallable()
    {
        $mA = new Matrix(array(array(1)));
        $this->object->transform($mA, 'foo');
    }


    /**
     * @dataProvider computeMatrices
     */
    public function testComputeReturnsCorrectResult($operand, $function, $result)
    {
        $mA = new Matrix($operand);
        $this->assertEquals($result, $this->object->transform($mA, $function)->toArray());
    }

    /**
     *
     * @return array[[operand, result],...]
     */
    public function computeMatrices()
    {
        return array(
            array(
                array(array(1,2), array(2,1)),
                function($row, $col, $value) {return $row * $col * $value;},
                array(array(1,4), array(4,4)),
            ),
        );
    }

}
