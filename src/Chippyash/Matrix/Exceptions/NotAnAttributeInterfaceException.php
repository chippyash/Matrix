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
 * Invalid attribute interface
 */
class NotAnAttributeInterfaceException extends MatrixException
{
    protected $msgTpl = "Attribute: %s is not an AttributeInterface";

    public function __construct($attr, $code = -1, $previous = null)
    {
        $message = sprintf($this->msgTpl, $attr);
        parent::__construct($message, $code, $previous);
    }
}
