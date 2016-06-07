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
 * Assert matrix is not empty
 */
Trait AssertMatrixIsNotEmpty
{
    /**
     * Check matrix is not empty
     *
     * @param \Chippyash\Matrix\Matrix $matrix
     * @param string $msg optional error message`
     *
     * @return $this
     *
     * @throws MatrixException
     */
    protected function assertMatrixIsNotEmpty(Matrix $matrix, $msg = 'Matrix parameter is empty')
    {
        if ($matrix->is('empty')) {
            throw new MatrixException($msg);
        }

        return $this;
    }
}
