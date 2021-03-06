<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace Chippyash\Matrix\Transformation;

use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Traits\AssertMatrixIsComplete;
use Chippyash\Matrix\Traits\AssertParameterIsMatrix;
use Chippyash\Matrix\Traits\AssertMatrixRowsAreEqual;

/**
 * Concatenate two matrices
 *
 * [[a,b]   [[e,f]  [[a,b,e,f]
 *  [c,d]  C [g,h] = [c,d,g,h]
 */
class Concatenate extends AbstractTransformation
{
    use AssertMatrixIsComplete;
    use AssertParameterIsMatrix;
    use AssertMatrixRowsAreEqual;

    /**
     * Concatenate the $extra matrix to the right of $mA
     *
     * @param Matrix $mA First matrix operand - required
     * @param Matrix $extra Second matrix operand - required
     *
     * @return Matrix
     *
     */
    protected function doTransform(Matrix $mA, $extra = null)
    {
        /** @noinspection PhpInternalEntityUsedInspection */
        $this->assertParameterIsMatrix($extra)
             ->assertMatrixRowsAreEqual($mA, $extra)
             ->assertMatrixIsComplete($mA)
             ->assertMatrixIsComplete($extra);

        //previous checks have determined both matrices have same number of
        //rows - so we only need to check one for zero rows
        if ($mA->is('empty')) {
            return new Matrix(array());
        }

        $data = array();
        $mAData = $mA->toArray();
        $mBData = $extra->toArray();
        $rows = $mA->rows();
        for ($row=0; $row<$rows; $row++) {
            $data[$row] = array_merge($mAData[$row], $mBData[$row]);
        }

        return new Matrix($data);
    }

}
