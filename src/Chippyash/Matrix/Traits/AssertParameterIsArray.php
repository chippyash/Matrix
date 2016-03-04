<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Matrix\Traits;

use Chippyash\Matrix\Exceptions\MatrixException;

/**
 * Assert parameter is an array
 */
Trait AssertParameterIsArray
{
    /**
     * Run test to ensure parameter is an array
     *
     * @param mixed $value
     * @param string $msg Optional message
     *
     * @return Fluent Interface
     *
     * @throws MatrixException
     */
    protected function assertParameterIsArray($param, $msg = 'Parameter is not an array')
    {
        if (!is_array($param)) {
            throw new MatrixException($msg);
        }

        return $this;
    }
}
