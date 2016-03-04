<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Matrix\Interfaces;

use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Interfaces\InvokableInterface;

/**
 * Interface for a Matrix transformation
 * Transformations return a Matrix by transforming the operand Matrix
 * into something else
 *
 * @codeCoverageIgnore
 */
interface TransformationInterface extends InvokableInterface
{
    /**
     * Transform a matrix
     *
     * @param Matrix $mA
     * @param mixed $extra Additional input required for transformation
     * @return Matrix
     * @codeCoverageIgnore
     */
    public function transform(Matrix $mA, $extra = null);

}
