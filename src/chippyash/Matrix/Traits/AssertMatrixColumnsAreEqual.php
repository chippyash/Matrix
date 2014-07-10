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
 * Assert column count in two matrices are equal
 */
Trait AssertMatrixColumnsAreEqual
{
    /**
     * @param \chippyash\Matrix\Matrix $matrix
     * @param string $msg Optional message
     *
     * @return Fluent Interface
     *
     * @throws MatrixException
     */
    protected function assertMatrixColumnsAreEqual(Matrix $mA, Matrix $mB, $msg = 'mA->cols != mB->cols')
    {
        if ($mA->columns() != $mB->columns()) {
            throw new MatrixException($msg);
        }

        return $this;
    }
}
