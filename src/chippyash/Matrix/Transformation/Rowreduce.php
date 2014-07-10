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
use chippyash\Matrix\Traits\AssertParameterIsArray;
use chippyash\Matrix\Traits\AssertMatrixIsComplete;

/**
 * Take rows out of a Matrix
 */
class Rowreduce extends AbstractTransformation
{
    use AssertParameterIsArray;
    use AssertMatrixIsComplete;

    /**
     * Take a rows out of the matrix
     *
     * @param Matrix $mA First matrix operand - required
     * @param array $extra [int startRow, int numRows = 1]
     *
     * @return Matrix
     *
     * @throws chippyash/Matrix/Exceptions/MatrixException
     */
    public function transform(Matrix $mA, $extra = null)
    {
        if ($mA->is('empty')) {
            return new Matrix(array());
        }

        $this->assertParameterIsArray($extra, 'Second operand is not an array');

        if (empty($extra)) {
            throw new MatrixException('Second operand does not contain row indicator');
        }
        $row = intval($extra[0]);
        $availableRows = $mA->rows();
        if ($row<1 || $row > $availableRows) {
            throw new MatrixException('Row indicator out of bounds');
        }

        $numRows = (isset($extra[1]) ? intval($extra[1]) : 1);
        if ($numRows < 1 || ($numRows+$row-1) > $availableRows) {
            throw new MatrixException('Numrows out of bounds');
        }
        $this->assertMatrixIsComplete($mA);


        $data = $mA->toArray(false);
        $rowEnd = $row-1+$numRows;
        for ($r = $row-1; $r < $rowEnd; $r++) {
            unset($data[$r]);
        }

        return new Matrix(array_values($data));
    }
}
