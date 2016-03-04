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
 * Is matrix a diagonal matrix?
 * Only entries on the main diagonal are non-zero
 * All other entries are zero
 */
class IsDiagonal implements AttributeInterface
{
    /**
     * Does the matrix have this attribute
     *
     * @param Matrix $mA
     * @return boolean
     */
    public function is(Matrix $mA)
    {
        if (!$mA->is('square')) {
            return false;
        }

        $size = $mA->rows();
        $data = $mA->toArray();
        for ($row = 0; $row < $size; $row ++) {
            for ($col = 0; $col < $size; $col ++) {
                if (($row == $col)) {
                    if ($data[$row][$col] == 0) {
                        return false;
                    }
                } else {
                    if ($data[$row][$col] != 0) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}
