<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace Chippyash\Matrix\Transformation;

use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Exceptions\MatrixException;
use Chippyash\Matrix\Traits\AssertParameterIsArray;
use Chippyash\Matrix\Traits\AssertMatrixIsComplete;

/**
 * Take a row slice of a Matrix
 */
class Rowslice extends AbstractTransformation
{
    use AssertParameterIsArray;
    use AssertMatrixIsComplete;

    /**
     * Take a row slice from the matrix
     *
     * @param Matrix $mA First matrix operand - required
     * @param array $extra [int startRow, int numRows = 1]
     *
     * @return Matrix
     *
     * @throws MatrixException
     */
    protected function doTransform(Matrix $mA, $extra = null)
    {
        if ($mA->is('empty')) {
            return new Matrix(array());
        }

        /** @noinspection PhpInternalEntityUsedInspection */
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

        return $this->doTransformation($mA, $row, $numRows);
    }
    
    /**
     * Carry out the transformation
     * 
     * @param \Chippyash\Matrix\Matrix $mA
     * @param int $row Start row
     * @param int $numRows Number of rows
     * 
     * @return \Chippyash\Matrix\Matrix
     */
    protected function doTransformation(Matrix $mA, $row, $numRows)
    {
        $data = $mA->toArray();

        return new Matrix(array_slice($data, $row-1, $numRows));
    }
}
