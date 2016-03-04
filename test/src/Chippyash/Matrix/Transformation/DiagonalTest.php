<?php
namespace Chippyash\Test\Matrix\Transformation;
use Chippyash\Matrix\Transformation\Diagonal;
use Chippyash\Matrix\Matrix;

/**
 * Description of DiagonalTest
 *
 */
class DiagonalTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new Diagonal();
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix is not complete in row 2
     */
    public function testComputeThrowsExceptionMatrixNotComplete()
    {
        $m = new Matrix(array(array(1,2),array(1)));
        $this->object->transform($m);
    }

    public function testEmptyMatrixReturnsEmptyMatrix()
    {
        $mA = new Matrix(array());
        $test = $this->object->transform($mA);
        $this->assertTrue($test->is('Empty'));
    }

    public function testComputeReturnsCorrectResult()
    {
        $mA = new Matrix(
                array(
                    array(1,2,3),
                    array(1,2,3),
                    array(1,2,3)));
        $mB = $this->object->transform($mA);

        $this->assertFalse($mA->is('diagonal'));
        $this->assertTrue($mB->is('diagonal'));
        $this->assertEquals(
                array(
                    array(1,0,0),
                    array(0,2,0),
                    array(0,0,3)),
                $mB->toArray());
    }

}
