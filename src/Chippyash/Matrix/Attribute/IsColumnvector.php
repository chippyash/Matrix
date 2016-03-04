<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 * @link http://en.wikipedia.org/wiki/Matrix_(mathematics)
 */
namespace Chippyash\Matrix\Attribute;

use Chippyash\Matrix\Interfaces\AttributeInterface;
use Chippyash\Matrix\Matrix;

/**
 * Is matrix a column vector?
 */
class IsColumnvector implements AttributeInterface
{
    /**
     * Does the matrix have this attribute
     *
     * @param Matrix $mA
     * @return boolean
     */
    public function is(Matrix $mA)
    {
        return ($mA->rows() > 1 && $mA->columns() == 1);
    }
}
