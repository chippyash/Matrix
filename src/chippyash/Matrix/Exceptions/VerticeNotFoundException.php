<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace chippyash\Matrix\Exceptions;

use chippyash\Matrix\Exceptions\MatrixException;

/**
 * Thrown if a vertice is not found in the matrix
 */
class VerticeNotFoundException extends MatrixException
{
    protected $msgTpl = "Vertice R(%d),C(%d) is not found in the matrix";

    public function __construct($row, $col, $code = -1, $previous = null)
    {
        $message = sprintf($this->msgTpl, $row, $col);
        parent::__construct($message, $code, $previous);
    }
}
