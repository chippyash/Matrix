<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Matrix\Traits;

use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Exceptions\MatrixException;

/**
 * Assert row count in two matrices are equal
 */
Trait AssertMatrixRowsAreEqual
{
    /**
     * @param \Chippyash\Matrix\Matrix $matrix
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
