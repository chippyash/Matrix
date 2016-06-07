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
 * Square attribute
 *
 * A square matrix is a complete matrix with m==n
 */
class IsSquare implements AttributeInterface
{
    /**
     * Does the matrix have this attribute
     *
     * @param Matrix $mA
     * @return boolean
     */
    public function is(Matrix $mA)
    {
        //nb isComplete will return true if mA is empty
        $isComplete = new IsComplete();
        if (!$isComplete->is($mA)) {
            return false;
        }
        $m = $mA->rows();
        $n = $mA->columns();

        return ($m == $n);
    }
}
