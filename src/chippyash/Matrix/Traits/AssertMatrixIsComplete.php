<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace chippyash\Matrix\Traits;

use chippyash\Matrix\Matrix;
use chippyash\Matrix\Exceptions\NotCompleteMatrixException;
use chippyash\Matrix\Attribute\IsComplete;

/**
 * Assert matrix is complete
 */
Trait AssertMatrixIsComplete
{
    /**
     * Run test to ensure matrix is complete i.e. fully populated
     *
     * @param \chippyash\Matrix\Matrix $matrix
     *
     * @return Fluent Interface
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
