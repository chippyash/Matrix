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

/**
 * Specifies interface for output formatter
 *
 * @codeCoverageIgnore
 */
interface FormatterInterface
{
    /**
     * Format the matrix contents for outputting
     *
     * @param Matrix $mA Matrix to format
     * @param array $options Options for formatter
     *
     * @return mixed
     * @codeCoverageIgnore
     */
    public function format(Matrix $mA, array $options = array());
}
