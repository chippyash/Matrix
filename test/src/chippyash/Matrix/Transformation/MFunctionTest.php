<?php
namespace chippyash\Test\Matrix\Transformation;
use chippyash\Matrix\Transformation\MFunction;
use chippyash\Matrix\Matrix;

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
     * @expectedException chippyash\Matrix\Exceptions\NotCompleteMatrixException
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
        $this->assertInstanceOf('chippyash\Matrix\Matrix', $test);
        $this->assertTrue($test->is('Empty'));
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Function parameter is not callable
     */
    public function testSecondParameterToComputeIsNotOptional()
    {
        $mA = new Matrix(array(array(1)));
        $this->object->transform($mA);
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
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
