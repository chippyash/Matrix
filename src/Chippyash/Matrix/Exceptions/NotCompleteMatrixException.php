<?php
/*
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace Chippyash\Matrix\Exceptions;

use Chippyash\Matrix\Exceptions\MatrixException;

/**
 * Thrown if matrix is not complete
 */
class NotCompleteMatrixException extends MatrixException
{
    protected $msgTpl = "Matrix is not complete in row %d";

    public function __construct($rowNum, $code = -1, $previous = null)
    {
        $message = sprintf($this->msgTpl, $rowNum);
        parent::__construct($message, $code, $previous);
    }
}
