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
use chippyash\Matrix\Formatter\Ascii;

/**
 * Adds dump of a matrix or array using the Ascii formatter
 */
Trait Debug
{

    /**
     * Are we in debug mode?
     * @var boolean
     */
    protected $debug = false;


    /**
     * Set the debug mode
     *
     * @param boolean $flag
     * @return \chippyash\Matrix\Transformation\AbstractTransformation
     */
    public function setDebug($flag = true)
    {
        $this->debug = (boolean) $flag;
        return $this;
    }

    /**
     * Echo message + matrix|array to screen
     *
     * @param string $msg
     * @param \chippyash\Matrix\Matrix|array $aA
     * @return void
     * @throws \Exception
     * @codeCoverageIgnore
     */
    protected function debug($msg, $aA)
    {
        if (!$this->debug) return;

        $mA = (is_array($aA) ? new Matrix($aA) : ($aA instanceof Matrix ? $aA : false));
        if ($mA === false) {
            throw new \Exception('Debug parameter is not an array or a matrix');
        }
        $out = $msg
             . PHP_EOL
             . $mA->setFormatter(new Ascii())
                ->display()
             . PHP_EOL;

        echo $out;
    }
}
