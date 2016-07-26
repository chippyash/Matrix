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
 * Shift matrix columns left or right across the matrix
 * replacing the new column with null (default) or user specified value
 *
 */
class Shift extends AbstractTransformation
{

    use AssertMatrixIsComplete;

    /**
     * Shift matrix rows columns left or right across the matrix
     *
     * The extra param specifies the number of columns to shift and optionally the
     * replacement value
     *
     * @param Matrix $mA First matrix operand - required
     * @param array $extra [Number of columns to shift - default = 1, [replacement value]] - optional
     *
     * @return Matrix
     *
     * @throws TransformationException
     */
    protected function doTransform(Matrix $mA, $extra = null)
    {
        $this->assertMatrixIsComplete($mA);

        if ($mA->is('empty')) {
            return clone $mA;
        }

        $numShifts = (is_null($extra) ? 1 : (isset($extra[0]) ? intval($extra[0]) : 1));
        if (0 == $numShifts) {
            return clone $mA;
        }

        $newValue = (is_null($extra) ? null : (isset($extra[1]) ? $extra[1] : null));
        if ($mA->is('singleitem')) {
            return new Matrix([$newValue]);
        }
        
        $replaceCVector = $this->createCVector($mA, $newValue);
        if ($mA->is('columnvector')) {
            return $replaceCVector;
        }
        
        //let's process the matrix
        $direction = ($numShifts < 0 ? -1 : 1);
        $nCols = $mA->columns() - 1;
        $fSlice = new Colslice();
        $fConc = new Concatenate();
        $fReflect = new Reflect();
        $ret = ($direction == 1 ? clone $mA : $fReflect($mA, Reflect::REFL_Y));

        for ($x = abs($numShifts); $x--; $x==0) {
            $ret = $fConc($replaceCVector, $fSlice($ret, [1, $nCols]));
        }    
        
        return ($direction == 1 ? $ret : $fReflect($ret, Reflect::REFL_Y));
    }

    /**
     * @param Matrix $mA Original Matrix
     * @param mixed $newValue new value to be used in replacement
     * @return Matrix Column Vector
     */
    protected function createCVector(Matrix $mA, $newValue)
    {
        $fTran = new Transpose();
        return $fTran(new Matrix(array_fill(0, $mA->rows(), $newValue)));
    }
}
