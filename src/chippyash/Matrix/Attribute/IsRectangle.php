<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 * @link http://en.wikipedia.org/wiki/Matrix_(mathematics)
 */
namespace chippyash\Matrix\Attribute;

use chippyash\Matrix\Interfaces\AttributeInterface;
use chippyash\Matrix\Matrix;

/**
 * Is matrix a rectangle?
 */
class IsRectangle implements AttributeInterface
{
    /**
     * Does the matrix have this attribute
     *
     * @param Matrix $mA
     * @return boolean
     */
    public function is(Matrix $mA)
    {
        $r = $mA->rows();
        $c = $mA->columns();

        return (($r > 1 && $c > 1) && ($r != $c));
    }
}
