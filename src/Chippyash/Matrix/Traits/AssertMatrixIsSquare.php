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
 * Assert matrix is square
 */
Trait AssertMatrixIsSquare
{
    /**
     * Check that matrix is square
     *
     * @param \Chippyash\Matrix\Matrix $matrix
     * @param string $msg Optional message
     * @return $this
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
