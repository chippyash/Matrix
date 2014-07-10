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
 * Assert matrix is square
 */
Trait AssertMatrixIsSquare
{
    /**
     * Check that matrix is square
     *
     * @param \chippyash\Matrix\Matrix $matrix
     * @param string $msg Optional message
     * @return Fluent Interface
     *
     * @throws MatrixException
     */
    protected function assertMatrixIsSquare(Matrix $matrix , $msg = 'Matrix is not square')
    {
        if (!$matrix->is('square')) {
            throw new MatrixException($msg);
        }

        return $this;
    }
}
