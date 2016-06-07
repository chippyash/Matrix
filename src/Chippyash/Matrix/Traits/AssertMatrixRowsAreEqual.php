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
     * @param Matrix $mA
     * @param Matrix $mB
     * @param string $msg Optional message
     * 
     * @return $this
     *
     * @throws MatrixException
     * @internal param Matrix $matrix
     */
    protected function assertMatrixRowsAreEqual(Matrix $mA, Matrix $mB, $msg = 'mA->rows != mB->rows')
    {
        if ($mA->rows() != $mB->rows()) {
            throw new MatrixException($msg);
        }

        return $this;
    }
}
