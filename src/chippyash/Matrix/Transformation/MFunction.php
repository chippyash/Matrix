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
use chippyash\Matrix\Matrix;
use chippyash\Matrix\Exceptions\MatrixException;
use chippyash\Matrix\Traits\AssertMatrixIsComplete;

/**
 * Apply a function to every entry in the matrix
 */
class MFunction extends AbstractTransformation
{
    use AssertMatrixIsComplete;

    /**
     * Apply a function to every entry in the matrix
     *
     * Parameter signature for function to be used is:
     * function($row, $col, $value)
     *
     * @param Matrix $mA First matrix operand - required
     * @param callable $extra The function to apply
     *
     * @return Matrix
     *
     * @throws chippyash/Matrix/Exceptions/ComputationException
     */
    protected function doTransform(Matrix $mA, $extra = null)
    {
        $this->assertMatrixIsComplete($mA);

        if ($mA->is('empty')) {
            return new Matrix(array());
        }

        if (!is_callable($extra)) {
            throw new MatrixException('Function parameter is not callable');
        }

        $data = array();
        $mAData = $mA->toArray();
        $rows = $mA->rows();
        $cols = $mA->columns();
        for ($row=0; $row<$rows; $row++) {
            for ($col=0; $col<$cols; $col++) {
                $data[$row][$col] = $extra($row+1, $col+1, $mAData[$row][$col]);
            }
        }

        return new Matrix($data);
    }
}
