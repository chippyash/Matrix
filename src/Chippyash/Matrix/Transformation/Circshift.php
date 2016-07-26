<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace Chippyash\Matrix\Transformation;

use Chippyash\Matrix\Exceptions\TransformationException;
use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Traits\AssertMatrixIsComplete;

/**
 * Shift matrix columns left or right circularly around the matrix
 * NB - This does not lose data in the matrix
 *
 */
class Circshift extends AbstractTransformation
{

    use AssertMatrixIsComplete;

    /**
     * Shift matrix rows columns left or right circularly around the matrix
     *
     * The extra param specifies the number of columns to shift.  
     *
     * @param Matrix $mA First matrix operand - required
     * @param int $extra Number of columns to shift - default = 1
     *
     * @return Matrix
     *
     * @throws TransformationException
     */
    protected function doTransform(Matrix $mA, $extra = null)
    {
        $this->assertMatrixIsComplete($mA);

        //simple cases
        if ($mA->is('empty') || $mA->is('singleitem') || $mA->is('columnvector')) {
            return clone $mA;
        }

        $numShifts = (is_null($extra) ? 1 : intval($extra)); 
        if (0 == $numShifts) {
            return clone $mA;
        }
        
        //let's process the matrix
        $direction = ($numShifts < 0 ? -1 : 1);
        $nCols = $mA->columns();
        $fSlice = new Colslice();
        $fConc = new Concatenate();
        $fReflect = new Reflect();
        $ret = ($direction == 1 ? clone $mA : $fReflect($mA, Reflect::REFL_Y));

        for ($x = abs($numShifts); $x--; $x==0) {
            $ret = $fConc($fSlice($ret, [$nCols, 1]), $fSlice($ret, [1, $nCols - 1]));
        }    
        
        return ($direction == 1 ? $ret : $fReflect($ret, Reflect::REFL_Y));
    }
}
