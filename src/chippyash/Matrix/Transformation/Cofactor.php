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
use chippyash\Matrix\Transformation\Rowreduce;
use chippyash\Matrix\Transformation\Colreduce;
use chippyash\Matrix\Matrix;
use chippyash\Matrix\Exceptions\MatrixException;
use chippyash\Matrix\Traits\AssertParameterIsArray;

/**
 * Return the cofactor matrix
 */
class Cofactor extends AbstractTransformation
{
    use AssertParameterIsArray;

    /**
     * Return cofactor matrix for a given vertice
     *
     * @param Matrix $mA First matrix operand - required
     * @param array $extra [int row, int col]
     *
     * @return Matrix
     *
     * @throws chippyash/Matrix/Exceptions/MatrixException
     * @throws chippyash/Matrix/Exceptions/UndefinedMatrixException
     */
    protected function doTransform(Matrix $mA, $extra = null)
    {
        if ($mA->is('empty')) {
            return new Matrix([]);
        }
        $this->assertParameterIsArray($extra, 'Second operand is not an array');

        if (count($extra) != 2) {
            throw new MatrixException('Second operand does not contain row and column');
        }
        $row = intval($extra[0]);
        $col = intval($extra[1]);
        $size = $mA->rows();
        if ($row<1 || $row > $size) {
            throw new MatrixException('Row indicator out of bounds');
        }
        if ($col<1 || $col > $size) {
            throw new MatrixException('Col indicator out of bounds');
        }

        $fC = new Colreduce();
        $fR = new Rowreduce();
        //R(C(mA))
        return $fR($fC($mA,[$col]),[$row]);
    }

}
