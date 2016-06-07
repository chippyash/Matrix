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
 * No formatter set
 */
class FormatterNotSetException extends MatrixException
{
    protected $msgTpl = "Formatter not set";

    public function __construct($msg = null, $code = -1, $previous = null)
    {
        parent::__construct($this->msgTpl, $code, $previous);
    }
}
