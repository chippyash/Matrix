<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace chippyash\Matrix\Transformation;

use chippyash\Matrix\Transformation\AbstractTransformation;
use chippyash\Matrix\Exceptions\TransformationException;
use chippyash\Matrix\Matrix;
use chippyash\Matrix\Traits\AssertMatrixIsComplete;

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

    private $rotationMatrices = [
        self::ROT_90 => [[0,-1],[1,0]],
        self::ROT_180 => [[-1, 0],[0, -1]],
        self::ROT_270 => [[0, 1],[-1, 0]],
    ];


    /**
     * Concatenate the $extra matrix to the right of $mA
     *
     * @param Matrix $mA First matrix operand - required
     * @param int $extra Rotation degrees - default null = self::ROT_90 (counter clockwise)
     *
     * @return Matrix
     *
     */
    public function transform(Matrix $mA, $extra = null)
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
     * @param \chippyash\Matrix\Matrix $mA
     * @param array $rotationMatrix rotation vector matrix
     * @return \chippyash\Matrix\Matrix
     */
    protected function rotate(Matrix $mA, array $rotationMatrix)
    {
        $source = $mA->toArray();
        $result = [];
        for ($row = 0; $row < $mA->rows(); $row++) {
            for ($col = 0; $col < $mA->columns(); $col++) {
                list($nRow, $nCol) = $this->rot($row, $col, $rotationMatrix);
                $result[$nRow][$nCol] = $source[$row][$col];
            }
        }

        return new Matrix($this->rebase($result));
    }

    /**
     * Find new vertice after rotation
     *
     * [a, b]   [y]    [bx + ay]
     * [c, d] . [x] =  [dx + cy]
     *
     * @param int $y Y coord (row)
     * @param int $x X coord (column)
     * @param array $r rotation matrix
     * @return array
     */
    protected function rot($y, $x, array $r)
    {
        $ny = $r[0][1] * $x + $r[0][0] * $y;
        $nx = $r[1][1] * $x + $r[1][0] * $y;

        return [$ny, $nx];
    }

    /**
     * Sort and rebase the result array to zero
     *
     * @param array $a
     * @return array
     */
    protected function rebase(array $a)
    {
        $res = [];
        ksort($a);
        foreach(array_values($a) as $row) {
            ksort($row);
            $res[] = array_values($row);
        }

        return $res;
    }
}
