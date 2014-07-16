<?php
namespace chippyash\Test\Matrix\Transformation;
use chippyash\Matrix\Transformation\Transpose;
use chippyash\Matrix\Matrix;

/**
 * Description of TransposeTest
 *
 */
class TransposeTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new Transpose();
    }

    public function testSecondOperandIgnored()
    {
        $mA = new Matrix(array());
        $this->assertInstanceOf('chippyash\Matrix\Matrix', $this->object->transform($mA, 'foo'));
        $this->assertInstanceOf('chippyash\Matrix\Matrix', $this->object->transform($mA, array()));
        $this->assertInstanceOf('chippyash\Matrix\Matrix', $this->object->transform($mA, tmpfile()));
        $this->assertInstanceOf('chippyash\Matrix\Matrix', $this->object->transform($mA, new \stdClass()));
    }

    public function testEmptyMatrixReturnsEmptyMatrix()
    {
        $mA = new Matrix(array());
        $test = $this->object->transform($mA);
        $this->assertInstanceOf('chippyash\Matrix\Matrix', $test);
        $this->assertTrue($test->is('Empty'));
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix is not complete in row 2
     */
    public function testComputeThrowsExceptionIfFirstOperandIsIncompleteMatrix()
    {
        $m = new Matrix(array(array(1,2),array(1)));
        $this->object->transform($m, $m);
    }

    /**
     * @dataProvider computeMatrices
     */
    public function testComputeReturnsCorrectResult($operand, $result)
    {
        $mA = new Matrix($operand);
        $this->assertEquals($result, $this->object->transform($mA)->toArray());
    }

    /**
     * t(t(A)) = A
     * @dataProvider computeMatrices
     */
    public function testComputeATtotheTReturnsCorrectResult($operand)
    {
        $mA = new Matrix($operand);
        $this->assertEquals($operand, $this->object->transform($this->object->transform($mA))->toArray());
        $T = $this->object;
        $this->assertEquals($operand, $T($T($mA))->toArray());
    }

    /**
     *
     * @return array[[operand, result],...]
     */
    public function computeMatrices()
    {
        return [
            [
                [
                    [1,3,5],
                    [2,4,6]
                ],
                [
                    [1,2],
                    [3,4],
                    [5,6]
                ],
            ],
            [
                [
                    [1,2],
                    [3,4],
                    [5,6]],
                [
                    [1,3,5],
                    [2,4,6]
                ],
            ],
            [
                [[1]],
                [[1]],
            ],
            [
                [
                    [1,2]
                ],
                [
                    [1],
                    [2]
                ],
            ],
            [
                [
                    [ 1,  2,  3,  4,  5],
                    [ 6,  7,  8,  9, 10],
                    [11, 12, 13, 14, 15],
                    [16, 17, 18, 19, 20],
                    [21, 22, 23, 24, 25]
                ],
                [
                    [1,  6, 11, 16, 21],
                    [2,  7, 12, 17, 22],
                    [3,  8, 13, 18, 23],
                    [4,  9, 14, 19, 24],
                    [5, 10, 15, 20, 25]
                ]
            ]
        ];
    }

}
