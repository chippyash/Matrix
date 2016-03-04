<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace chippyash\Matrix\Traits;

use chippyash\Matrix\Matrix;
use chippyash\Matrix\Exceptions\MatrixException;

/**
 * Assert row count in two matrices are equal
 */
Trait AssertMatrixRowsAreEqual
{
    /**
     * @param \chippyash\Matrix\Matrix $matrix
     * @param string $msg Optional message
     *
     * @return Fluent Interface
     *
     * @throws MatrixException
     */
    protected function assertMatrixRowsAreEqual(Matrix $mA, Matrix $mB, $msg = 'mA->rows != mB->rows')
    {
        if ($mA->rows() != $mB->rows()) {
            throw new MatrixException($msg);
        }

        return $this;
    }
}
