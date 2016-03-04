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
 * Rotate a matrix by 90, 180 or 270 degrees
 * Rotations are all counter clockwise so a 270 degree rotation == 90 deg clockwise
 *
 * @link http://en.wikipedia.org/wiki/Rotation_matrix
 */
class Rotate extends AbstractTransformation
{

    use AssertMatrixIsComplete;

    const ROT_90 = 0;     //rotate anti clockwise 90 deg
    const ROT_180 = 1;    //rotate 180 deg (mirror vertically)
    const ROT_270 = 2;    //rotate clockwise 90 deg (270 deg anti clockwise)

    /**
     * Rotation matrices
     *
     * |Y|   |a,b| |y|
     * |X| = |c,d|x|x|
     *
     *     = |bx + ay|
     *       |dx + cy|
     *
     * @var array
     */
    private $rotationMatrices = [
        self::ROT_90 => [[0,-1],[1,0]],
        self::ROT_180 => [[-1, 0],[0, -1]],
        self::ROT_270 => [[0, 1],[-1, 0]],
    ];


    /**
     * Rotate the matrix through 90, 180 or 270 degrees
     *
     * @param Matrix $mA First matrix operand - required
     * @param int $extra Rotation degrees - default null = self::ROT_90 (counter clockwise)
     *
     * @return Matrix
     *
     * @throws \Chippyash\Matrix\Exceptions\TransformationException
     */
    protected function doTransform(Matrix $mA, $extra = null)
    {
        if (is_null($extra)) {
            $extra = self::ROT_90;
        } else {
            if (!array_key_exists($extra, $this->rotationMatrices)) {
                throw new TransformationException('Rotation angle not supported');
            }
        }

        //simple cases
        if ($mA->is('empty') || $mA->is('singleitem')) {
            return clone $mA;
        }

        $this->assertMatrixIsComplete($mA);

        return $this->rotate($mA, $this->rotationMatrices[$extra]);
    }

    /**
     * Rotate the matrix
     *
     * @param \Chippyash\Matrix\Matrix $mA
     * @param array $rotationMatrix rotation vector matrix
     * @return \Chippyash\Matrix\Matrix
     */
    protected function rotate(Matrix $mA, array $rotationMatrix)
    {
        $a = $rotationMatrix[0][0];
        $b = $rotationMatrix[0][1];
        $c = $rotationMatrix[1][0];
        $d = $rotationMatrix[1][1];
        $f = function($x, $y, $val) use ($a, $b, $c, $d) {
            $nY = $b * $x + $a * $y;
            $nX = $d * $x + $c * $y;
            return [$nX, $nY, $val];
        };

        $vS = new VectorSet();
        return $vS->fromMatrix($mA)->translate($f)->toMatrix();
    }
}
