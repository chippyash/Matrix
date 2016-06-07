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
 * Thrown if a vertice is out of bounds for the matrix
 */
class VerticeOutOfBoundsException extends MatrixException
{
    protected $msgTpl = "Vertice '%s' is out of bounds with value: %d";

    public function __construct($vertice, $value, $code = -1, $previous = null)
    {
        $message = sprintf($this->msgTpl, $vertice, $value);
        parent::__construct($message, $code, $previous);
    }
}
