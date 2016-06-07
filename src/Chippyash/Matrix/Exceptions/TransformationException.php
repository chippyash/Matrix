<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace Chippyash\Matrix\Exceptions;

/**
 * Something went wrong in a transformation
 */
class TransformationException extends MatrixException
{
    protected $msgTpl = "Transformation exception: %s";

    public function __construct($cause = 'unknown', $code = -1, $previous = null)
    {
        $msg = sprintf($this->msgTpl, $cause);
        parent::__construct($msg, $code, $previous);
    }
}
