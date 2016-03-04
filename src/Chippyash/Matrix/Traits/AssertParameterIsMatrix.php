<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 * @link http://en.wikipedia.org/wiki/Matrix_(mathematics)
 */
namespace Chippyash\Matrix\Traits;

use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Exceptions\MatrixException;

/**
 * Assert parameter is a Matrix
 */
Trait AssertParameterIsMatrix
{
    /**
     * Run test to ensure parameter is a Matrix
     *
     * @param mixed $value
     * @param string $msg Optional message
     *
     * @return Fluent Interface
     *
     * @throws MatrixException
     */
    protected function assertParameterIsMatrix($param, $msg = 'Parameter is not a matrix')
    {
        if (!$param instanceof Matrix) {
            throw new MatrixException($msg);
        }

        return $this;
    }
}
