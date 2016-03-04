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
 * Matrix is a single item attribute
 */
class IsSingleitem implements AttributeInterface
{
    /**
     * Does the matrix have this attribute
     *
     * @param Matrix $mA
     * @return boolean
     */
    public function is(Matrix $mA)
    {
        if ($mA->toArray() === array(array())) {
            //empty array is not a single item
            return false;
        }
        if ($mA->rows() > 1) {
            return false;
        }
        if ($mA->columns() > 1) {
            return false;
        }

        return true;
    }
}
