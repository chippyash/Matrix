<?php

namespace Chippyash\Test\Matrix\Transformation;

use Chippyash\Matrix\Transformation\Reflect;
use Chippyash\Matrix\Matrix;

/**
 *
 * @author akitson
 */
class ReflectTest extends \PHPUnit_Framework_TestCase
{

    protected $object;

    protected function setUp()
    {
        $this->object = new Reflect();
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\TransformationException
     * @expectedExceptionMessage Transformation exception: Reflection plane not specified
     */
    public function testYouMustSpecifyAReflectionPlane()
    {
        $mA = new Matrix(array(array(1, 2), array(1)));
        $this->object->transform($mA);
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix is not complete in row 2
     */
    public function testTransformThrowsExceptionIfFirstOperandIsIncompleteMatrix()
    {
        $mA = new Matrix(array(array(1, 2), array(1)));
        $this->object->transform($mA, Reflect::REFL_X);
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\TransformationException
     * @expectedExceptionMessage Transformation exception: Reflection plane not supported
     */
    public function testTransformThrowsExceptionForUnrecognizedRotationType()
    {
        $mA = new Matrix([[1, 2], [3, 4]]);
        $this->object->transform($mA, -1);
    }

    public function testEmptyMatrixReturnsEmptyMatrix()
    {
        $mA = new Matrix(array());
        $test = $this->object->transform($mA, Reflect::REFL_X);
        $this->assertInstanceOf('Chippyash\Matrix\Matrix', $test);
        $this->assertTrue($test->is('Empty'));
    }

    public function testSingleItemMatrixReturnsIdenticalMatrix()
    {
        $mA = new Matrix(array('foo'));
        $test = $this->object->transform($mA, Reflect::REFL_X);
        $this->assertEquals($mA, $test);
    }

    /**
     * @dataProvider XMatrices
     */
    public function testCanReflectOnXPlane($source, $result)
    {
        $this->assertEquals($result,
                $this->object->transform(new Matrix($source), Reflect::REFL_X)->toArray());
    }

    /**
     *
     * @return array(source, result)
     */
    public function XMatrices()
    {
        return [
            [
                [
                    [1, 2],
                    [3, 4]
                ],
                [
                    [3, 4],
                    [1, 2]
                ],
            ],
            [
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9]
                ],
                [
                    [7, 8, 9],
                    [4, 5, 6],
                    [1, 2, 3]
                ],
            ],
            [
                [
                    [ 1,  2,  3,  4],
                    [ 5,  6,  7,  8],
                    [ 9, 10, 11, 12],
                    [13, 14, 15, 16]
                ],
                [
                    [13, 14, 15, 16],
                    [ 9, 10, 11, 12],
                    [ 5,  6,  7,  8],
                    [ 1,  2,  3,  4],
                ],
                [
                    [1, 2, 3, 4, 5],
                ],
                [
                    [1, 2, 3, 4, 5],
                ]
            ],
            [
                [
                    [1],
                    [2],
                    [3],
                    [4],
                    [5]
                ],
                [
                    [5],
                    [4],
                    [3],
                    [2],
                    [1],
                ]
            ]
        ];
    }

    /**
     *
     * @dataProvider YMatrices
     */
    public function testCanReflectOnYPlane($source, $result)
    {
        $this->assertEquals($result,
                $this->object->transform(new Matrix($source), Reflect::REFL_Y)->toArray());
    }

    /**
     *
     * @return array(source, result)
     */
    public function YMatrices()
    {
        return [
            [
                [
                    [1, 2],
                    [3, 4]
                ],
                [
                    [2, 1],
                    [4, 3]
                ],
            ],
            [
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9]
                ],
                [
                    [3, 2, 1],
                    [6, 5, 4],
                    [9, 8, 7]
                ],
            ],
            [
                [
                    [ 1,  2,  3,  4],
                    [ 5,  6,  7,  8],
                    [ 9, 10, 11, 12],
                    [13, 14, 15, 16]
                ],
                [
                    [ 4, 3, 2, 1],
                    [ 8, 7, 6, 5],
                    [12,11,10, 9],
                    [16,15,14,13],
                ],
                [
                    [1, 2, 3, 4, 5],
                ],
                [
                    [5, 4, 3, 2, 1],
                ]
            ],
            [
                [
                    [1],
                    [2],
                    [3],
                    [4],
                    [5]
                ],
                [
                    [1],
                    [2],
                    [3],
                    [4],
                    [5]
                ]
            ]
        ];
    }

    /**
     *
     * @dataProvider OMatrices
     */
    public function testCanReflectThroughOrigin($source, $result)
    {
        $this->assertEquals($result,
                $this->object->transform(new Matrix($source), Reflect::REFL_ORIGIN)->toArray());
    }

    /**
     *
     * @return array(source, result)
     */
    public function OMatrices()
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
                    [3, 2, 1]
                ],
            ],
            [
                [
                    [ 1,  2,  3,  4],
                    [ 5,  6,  7,  8],
                    [ 9, 10, 11, 12],
                    [13, 14, 15, 16]
                ],
                [
                    [ 16, 15, 14, 13],
                    [ 12, 11, 10,  9],
                    [  8,  7,  6,  5],
                    [  4,  3,  2,  1],
                ],
                [
                    [1, 2, 3, 4, 5],
                ],
                [
                    [5, 4, 3, 2, 1],
                ]
            ],
            [
                [
                    [1],
                    [2],
                    [3],
                    [4],
                    [5]
                ],
                [
                    [5],
                    [4],
                    [3],
                    [2],
                    [1]
                ]
            ]
        ];
    }

    /**
     *
     * @dataProvider YXMatrices
     */
    public function testCanReflectYEqualXPlane($source, $result)
    {
        $this->assertEquals($result,
                $this->object->transform(new Matrix($source), Reflect::REFL_TRANSPOSE)->toArray());
    }

    /**
     *
     * @return array(source, result)
     */
    public function YXMatrices()
    {
        return [
            [
                [
                    [1, 2],
                    [3, 4]
                ],
                [
                    [1, 3],
                    [2, 4]
                ],
            ],
            [
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9]
                ],
                [
                    [1, 4, 7],
                    [2, 5, 8],
                    [3, 6, 9]
                ],
            ],
            [
                [
                    [ 1,  2,  3,  4],
                    [ 5,  6,  7,  8],
                    [ 9, 10, 11, 12],
                    [13, 14, 15, 16]
                ],
                [
                    [ 1, 5, 9,  13],
                    [ 2, 6, 10, 14],
                    [ 3, 7, 11, 15],
                    [ 4, 8, 12, 16]
                ],
            ],
            [
                [
                    [1, 2, 3, 4, 5],
                ],
                [
                    [1],
                    [2],
                    [3],
                    [4],
                    [5]
                ]
            ],
            [
                [
                    [1],
                    [2],
                    [3],
                    [4],
                    [5]
                ],
                [
                    [1,2,3,4,5]
                ]
            ]
        ];
    }

}
