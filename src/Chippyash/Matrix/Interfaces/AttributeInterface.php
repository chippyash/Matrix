<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Matrix\Interfaces;

use Chippyash\Matrix\Matrix;

/**
 * Interface for a Matrix attribute
 * @codeCoverageIgnore
 */
interface AttributeInterface
{
    /**
     * Does the matrix have this attribute
     *
     * @param Matrix $mA
     * @return boolean
     * @codeCoverageIgnore
     */
    public function is(Matrix $mA);
}
