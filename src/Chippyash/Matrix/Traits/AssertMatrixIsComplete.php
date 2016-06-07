<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Matrix\Traits;

use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Exceptions\NotCompleteMatrixException;
use Chippyash\Matrix\Attribute\IsComplete;

/**
 * Assert matrix is complete
 */
Trait AssertMatrixIsComplete
{
    /**
     * Run test to ensure matrix is complete i.e. fully populated
     *
     * @param \Chippyash\Matrix\Matrix $matrix
     *
     * @return $this
     *
     * @throws NotCompleteMatrixException
     */
    protected function assertMatrixIsComplete(Matrix $matrix)
    {
        $test = new IsComplete();

        if (!$test->is($matrix)) {
            throw new NotCompleteMatrixException($test->getErrRow());
        }

        return $this;
    }
}
