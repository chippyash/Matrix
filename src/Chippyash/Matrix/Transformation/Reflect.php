<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace Chippyash\Matrix\Transformation;

use Chippyash\Matrix\Transformation\AbstractTransformation;
use Chippyash\Matrix\Exceptions\TransformationException;
use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Traits\AssertMatrixIsComplete;
use Chippyash\Matrix\Vector\VectorSet;

/**
 * Reflect a matrix through a plane
 *
 * @link http://en.wikipedia.org/wiki/Rotation_matrix
 */
class Reflect extends AbstractTransformation
{

    use AssertMatrixIsComplete;

    const REFL_X = 0;     //reflect through X axis
    const REFL_Y = 1;     //reflect through Y axis
    const REFL_ORIGIN = 2;    //reflect through origin
    const REFL_TRANSPOSE = 3;    //reflect through line y=x (i.e. == transpose)

    /**
     * Reflection matrices
     *
     * |X|   |a,b| |x|
     * |Y| = |c,d|x|Y|
     *
     *     = |by + ax|
     *       |dy + cx|
     *
     * @var array
     */
    private $reflectionMatrices = [
        self::REFL_X => [[1,0],
                         [0,-1]],
        self::REFL_Y => [[-1, 0],
                          [0, 1]],
        self::REFL_ORIGIN => [[-1, 0],
                              [0, -1]],
        self::REFL_TRANSPOSE => [[0,1],
                                 [1,0]],
    ];


    /**
     * Reflect the matrix on a plane
     *
     * @param Matrix $mA First matrix operand - required
     * @param int $extra Rotation degrees - required
     *
     * @return Matrix
     *
     * @throws \Chippyash\Matrix\Exceptions\TransformationException
     */
    protected function doTransform(Matrix $mA, $extra = null)
    {
        if (is_null($extra)) {
            throw new TransformationException('Reflection plane not specified');
        } else {
            if (!array_key_exists($extra, $this->reflectionMatrices)) {
                throw new TransformationException('Reflection plane not supported');
            }
        }

        //simple cases
        if ($mA->is('empty') || $mA->is('singleitem')) {
            return clone $mA;
        }

        $this->assertMatrixIsComplete($mA);

        return $this->reflect($mA, $this->reflectionMatrices[$extra]);
    }

    /**
     * Reflect the matrix
     *
     * @param \Chippyash\Matrix\Matrix $mA
     * @param array $reflectionMatrix reflection vector matrix
     * @return \Chippyash\Matrix\Matrix
     */
    protected function reflect(Matrix $mA, array $reflectionMatrix)
    {
        $a = $reflectionMatrix[0][0];
        $b = $reflectionMatrix[0][1];
        $c = $reflectionMatrix[1][0];
        $d = $reflectionMatrix[1][1];
        $f = function($x, $y, $val) use ($a, $b, $c, $d) {
            $nX = $b * $y + $a * $x;
            $nY = $d * $y + $c * $x;
            return [$nX, $nY, $val];
        };

        $vS = new VectorSet();
        return $vS->fromMatrix($mA)->translate($f)->toMatrix();
    }
}
