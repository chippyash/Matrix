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
use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Traits\AssertMatrixIsComplete;

/**
 * Transpose a matrix
 * @link http://en.wikipedia.org/wiki/Transpose
 * @link http://mikefenwick.com/blog/transposing-arrays-in-php-a-quick-way-to-loop-through-columns-from-a-sql-query/
 */
class Transpose extends AbstractTransformation
{
    use AssertMatrixIsComplete;
    /**
     * Transpose the matrix
     *
     * @param Matrix $mA First matrix operand - required
     * @param void $extra ignored
     *
     * @return Matrix
     *
     * @throws Chippyash/Matrix/Exceptions/MatrixException
     */
    protected function doTransform(Matrix $mA, $extra = null)
    {
        $this->assertMatrixIsComplete($mA);

        if ($mA->is('empty')) {
            return new Matrix(array());
        }
        $transposed = array();
        $data = $mA->toArray(false);
        foreach ($data as $rowKey => $row) {
            if (is_array($row) && !empty($row)) { //check to see if there is a second dimension
                foreach ($row as $columnKey => $element) {
                    $transposed[$columnKey][$rowKey] = $element;
                }
            }
        }

        return new Matrix($transposed);
    }

}
