<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2017
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace Chippyash\Matrix\Transformation;

use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Traits\AssertParameterIsArray;

/**
 * Resize a matrix
 */
class Resize extends AbstractTransformation
{
    use AssertParameterIsArray;

    /**
     * Resize the matrix by adding or subtracting rows and/or columns
     * to it.
     *
     * @param Matrix $mA First matrix operand - required
     * @param array $extra [int rows = 1, int cols = 1, mixed defaultValue = null]
     *
     * @return Matrix
     *
     */
    protected function doTransform(Matrix $mA, $extra = null)
    {
        /** @noinspection PhpInternalEntityUsedInspection */
        $this->assertParameterIsArray($extra, 'Second operand is not an array');

        $numRows = (isset($extra['rows']) ? (int) $extra['rows'] : 1);
        $numCols = (isset($extra['cols']) ? (int) $extra['cols'] : 1);
        $defValue = (isset($extra['defaultValue']) ? $extra['defaultValue'] : null);

        if ($numRows == 0 && $numCols == 0) {
            //no changes but return new matrix
            return clone $mA;
        }

        //cols only
        if ($numRows == 0 && $numCols != 0) {
            if ($numCols > 0) {
                return $this->addCols($mA, $numCols, $defValue);
            }

            return $this->reduceCols($mA, abs($numCols));
        }

        //rows only
        if ($numCols == 0 && $numRows != 0) {
            if ($numRows > 0) {
                return $this->addRows($mA, $numRows, $defValue);
            }

            return $this->reduceRows($mA, abs($numRows));
        }

        //so both cols and rows are changing
        $interim = (
            $numCols > 0
                ? $this->addCols($mA, $numCols, $defValue)
                : $this->reduceCols($mA, abs($numCols))
        );

        return (
            $numRows > 0
                ? $this->addRows($interim, $numRows, $defValue)
                : $this->reduceRows($interim, abs($numRows))
        );
    }

    /**
     * @param Matrix $mA
     * @param int    $numCols
     * @param int    $defValue
     *
     * @return Matrix
     */
    protected function addCols(Matrix $mA, $numCols, $defValue)
    {
        $data = array_fill(0, $mA->rows(), array_fill(0, $numCols, $defValue));

        return $mA('Concatenate', new Matrix($data));
    }

    /**
     * @param Matrix $mA
     * @param int    $numCols
     *
     * @return Matrix
     */
    protected function reduceCols(Matrix $mA, $numCols)
    {
        return $mA('Colreduce', [$mA->columns() - $numCols + 1, $numCols]);
    }

    /**
     * @param Matrix $mA
     * @param int    $numRows
     * @param mixed  $defValue
     *
     * @return Matrix
     */
    protected function addRows(Matrix $mA, $numRows, $defValue)
    {
        $data = array_fill(0, $numRows, array_fill(0, $mA->columns(), $defValue));

        return $mA('Stack', new Matrix($data));

    }

    /**
     * @param Matrix $mA
     * @param int    $numRows
     *
     * @return Matrix
     */
    protected function reduceRows(Matrix $mA, $numRows)
    {
        return $mA('Rowreduce', [$mA->rows() - $numRows, $numRows]);
    }
}
