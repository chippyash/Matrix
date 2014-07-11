<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace chippyash\Matrix\Transformation;

use chippyash\Matrix\Transformation\Rowslice;
use chippyash\Matrix\Matrix;

/**
 * Take rows out of a Matrix
 */
class Rowreduce extends Rowslice
{
   
    /**
     * Carry out the transformation
     * 
     * @param \chippyash\Matrix\Matrix $mA
     * @param int $row Start row
     * @param int $numRows Number of rows
     * 
     * @return \chippyash\Matrix\Matrix
     */
    protected function doTransformation(Matrix $mA, $row, $numRows)
    {
        $data = $mA->toArray();
        $rowEnd = $row-1+$numRows;
        for ($r = $row-1; $r < $rowEnd; $r++) {
            unset($data[$r]);
        }

        return new Matrix(array_values($data));
    }    
}
