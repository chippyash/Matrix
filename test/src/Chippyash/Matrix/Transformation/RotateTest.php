<?php

namespace Chippyash\Test\Matrix\Transformation;

use Chippyash\Matrix\Transformation\Rotate;
use Chippyash\Matrix\Matrix;

/**
 *
 * @author akitson
 */
class RotateTest extends \PHPUnit_Framework_TestCase
{

    protected $object;

    protected function setUp()
    {
        $this->object = new Rotate();
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix is not complete in row 2
     */
    public function testTransformThrowsExceptionIfFirstOperandIsIncompleteMatrix()
    {
        $mA = new Matrix(array(array(1, 2), array(1)));
        $this->object->transform($mA);
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\TransformationException
     * @expectedExceptionMessage Transformation exception: Rotation angle not supported
     */
    public function testTransformThrowsExceptionForUnrecognizedRotationType()
    {
        $mA = new Matrix([[1, 2], [3, 4]]);
        $this->object->transform($mA, -1);
    }

    public function testEmptyMatrixReturnsEmptyMatrix()
    {
        $mA = new Matrix(array());
        $test = $this->object->transform($mA);
        $this->assertInstanceOf('Chippyash\Matrix\Matrix', $test);
        $this->assertTrue($test->is('Empty'));
    }

    public function testSingleItemMatrixReturnsIdenticalMatrix()
    {
        $mA = new Matrix(array('foo'));
        $test = $this->object->transform($mA);
        $this->assertEquals($mA, $test);
    }

    /**
     * @dataProvider squareCCMatrices
     */
    public function testRotateSquareMatrixWillRotateCounterClockwise($source,
            $counterc)
    {
        //NB not providing a rotation type defaults to Rotate::ROT_90
        $this->assertEquals($counterc,
                $this->object->transform(new Matrix($source))->toArray());
    }

    /**
     *
     * @return array(source, counterc)
     */
    public function squareCCMatrices()
    {
        return [
            [
                [[]],
                [[]]
            ],
            [
                [[1]],
                [[1]]
            ],
            [
                [
                    [1, 2],
                    [3, 4]],
                [
                    [2, 4],
                    [1, 3]],
            ],
            [
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9]],
                [
                    [3, 6, 9],
                    [2, 5, 8],
                    [1, 4, 7]],
            ],
            [
                [
                    [ 1, 2, 3, 4],
                    [ 5, 6, 7, 8],
                    [ 9, 10, 11, 12],
                    [13, 14, 15, 16]
                ],
                [
                    [ 4, 8, 12, 16],
                    [ 3, 7, 11, 15],
                    [ 2, 6, 10, 14],
                    [ 1, 5, 9, 13]
                ],
            ],
        ];
    }

    public function testRotateRowVectorReturnsColumnVectorCounterClockwise()
    {
        $mA = new Matrix([[1, 2, 3, 4]]);
        $test = new Matrix([[4], [3], [2], [1]]);
        $this->object->transform($mA);
        $this->assertEquals($test, $this->object->transform($mA));
    }

    /**
     * @dataProvider squareClockwiseMatrices
     */
    public function testRotateSquareMatrixWillRotateClockwise($source,
            $clockwise)
    {
        $this->assertEquals(
                $clockwise,
                $this->object->transform(
                                new Matrix($source), Rotate::ROT_270)
                        ->toArray());
    }

    /**
     *
     * @return array(source, clockwise)
     */
    public function squareClockwiseMatrices()
    {
        return [
            [
                [[]],
                [[]]
            ],
            [
                [[1]],
                [[1]]
            ],
            [
                [
                    [1, 2],
                    [3, 4]],
                [
                    [3, 1],
                    [4, 2]],
            ],
            [
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9]],
                [
                    [7, 4, 1],
                    [8, 5, 2],
                    [9, 6, 3]],
            ],
            [
                [
                    [ 1, 2, 3, 4],
                    [ 5, 6, 7, 8],
                    [ 9, 10, 11, 12],
                    [13, 14, 15, 16]
                ],
                [
                    [13,  9, 5, 1],
                    [14, 10, 6, 2],
                    [15, 11, 7, 3],
                    [16, 12, 8, 4]
                ],
            ],
        ];
    }

    /**
     * @dataProvider squareOneEightyMatrices
     */
    public function testRotateSquareMatrixWillRotateOneEightyDegrees($source,
            $result)
    {
        $this->assertEquals(
                $result,
                $this->object->transform(
                                new Matrix($source), Rotate::ROT_180)
                        ->toArray());
    }

    /**
     *
     * @return array(source, result)
     */
    public function squareOneEightyMatrices()
    {
        return [
            [
                [
                    [1, 2],
                    [3, 4]
                ],
                [
                    [4, 3],
                    [2, 1]
                ],
            ],
            [
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9]
                ],
                [
                    [9, 8, 7],
                    [6, 5, 4],
                    [3, 2, 1],
                ],
            ],
            [
                [
                    [ 1, 2, 3, 4],
                    [ 5, 6, 7, 8],
                    [ 9, 10, 11, 12],
                    [13, 14, 15, 16]
                ],
                [
                    [16, 15, 14, 13],
                    [12, 11, 10, 9],
                    [ 8, 7, 6, 5],
                    [ 4, 3, 2, 1],
                ],
            ],
        ];
    }

    /**
     * @dataProvider rowMatrix
     */
    public function testRotateRowMatrixWillRotate($source, $ninety, $oneEighty,
            $twoSeventy)
    {
        $this->assertEquals(
                $ninety,
                $this->object->transform(
                                new Matrix($source), Rotate::ROT_90)
                        ->toArray());
        $this->assertEquals(
                $oneEighty,
                $this->object->transform(
                                new Matrix($source), Rotate::ROT_180)
                        ->toArray());
        $this->assertEquals(
                $twoSeventy,
                $this->object->transform(
                                new Matrix($source), Rotate::ROT_270)
                        ->toArray());
    }

    /**
     *
     * @return [source, ninety, oneEighty, twoSeventy]
     */
    public function rowMatrix()
    {
        return [
            [
                [[1, 2, 3, 4]],
                [
                    [4],
                    [3],
                    [2],
                    [1]],
                [[4, 3, 2, 1]],
                [
                    [1],
                    [2],
                    [3],
                    [4]]
            ],
        ];
    }

    /**
     * @dataProvider colMatrix
     */
    public function testRotateColMatrixWillRotate($source, $ninety, $oneEighty,
            $twoSeventy)
    {
        $this->assertEquals(
                $ninety,
                $this->object->transform(
                                new Matrix($source), Rotate::ROT_90)
                        ->toArray());
        $this->assertEquals(
                $oneEighty,
                $this->object->transform(
                                new Matrix($source), Rotate::ROT_180)
                        ->toArray());
        $this->assertEquals(
                $twoSeventy,
                $this->object->transform(
                                new Matrix($source), Rotate::ROT_270)
                        ->toArray());
    }

    /**
     *
     * @return [source, ninety, oneEighty, twoSeventy]
     */
    public function colMatrix()
    {
        return [
            [
                [
                    [1],
                    [2],
                    [3],
                    [4],
                ],
                [[1, 2, 3, 4]],
                [
                    [4],
                    [3],
                    [2],
                    [1],
                ],
                [[4, 3, 2, 1]],
            ],
        ];
    }

    public function testCombinedRotationsComputeCorrectly()
    {
        $mA = new Matrix([[1, 2], [3, 4]]);

        $twoXNinety = $this->object->transform(
                $this->object->transform($mA, Rotate::ROT_90), Rotate::ROT_90);
        $oneEighty = $this->object->transform($mA, Rotate::ROT_180);
        $threeXNinety = $this->object->transform(
                $this->object->transform(
                        $this->object->transform($mA, Rotate::ROT_90),
                        Rotate::ROT_90), Rotate::ROT_90);
        $oneEightyPlusNinety = $this->object->transform(
                $this->object->transform($mA, Rotate::ROT_90), Rotate::ROT_180);
        $twoSeventy = $this->object->transform($mA, Rotate::ROT_270);

        $this->assertEquals($twoXNinety, $oneEighty);
        $this->assertEquals($threeXNinety, $oneEightyPlusNinety);
        $this->assertEquals($threeXNinety, $twoSeventy);
        $this->assertEquals($oneEightyPlusNinety, $twoSeventy);
    }

}
