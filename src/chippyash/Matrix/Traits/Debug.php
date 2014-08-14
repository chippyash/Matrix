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
use chippyash\Matrix\Interfaces\FormatterInterface;

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
     * @var \chippyash\Matrix\Interfaces\FormatterInterface
     */
    protected $formatter;

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
     *
     * @param \chippyash\Matrix\Interfaces\FormatterInterface $formatter
     * @return mixed Fluent Interface
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;

        return $this;
    }

    /**
     * Echo message + matrix|array to screen
     *
     * @param string $msg
     * @param \chippyash\Matrix\Matrix|array $aA
     * @return void
     * @throws \Exception
     */
    protected function debug($msg, $aA)
    {
        if (!$this->debug) {
            return;
        }

        $mA = (is_array($aA) ? new Matrix($aA) : ($aA instanceof Matrix ? $aA : false));
        if ($mA === false) {
            throw new \Exception('Debug parameter is not an array or a matrix');
        }
        $out = $msg
             . PHP_EOL
             . $mA->setFormatter($this->getFormatter())
                ->display()
             . PHP_EOL;

        echo $out;
    }

    /**
     * Get formatter - use default Ascii formatter if not set
     *
     * @return \chippyash\Matrix\Interfaces\FormatterInterface
     */
    protected function getFormatter()
    {
        if (empty($this->formatter)) {
            $this->formatter = new Ascii();
        }

        return $this->formatter;
    }
}
