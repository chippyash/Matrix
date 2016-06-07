<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Matrix\Traits;

use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Formatter\Ascii;
use Chippyash\Matrix\Interfaces\FormatterInterface;

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
     * @var \Chippyash\Matrix\Interfaces\FormatterInterface
     */
    protected $formatter;

    /**
     *
     * @var array
     */
    protected $formatterOptions = [];

    /**
     * Set the debug mode
     *
     * @param boolean $flag
     * @return \Chippyash\Matrix\Transformation\AbstractTransformation
     */
    public function setDebug($flag = true)
    {
        $this->debug = (boolean) $flag;
        return $this;
    }

    /**
     *
     * @param \Chippyash\Matrix\Interfaces\FormatterInterface $formatter
     * @param array $options options to be passed to formatter via matrix->display()
     *
     * @return mixed $this
     */
    public function setFormatter(FormatterInterface $formatter, array $options = [])
    {
        $this->formatter = $formatter;
        $this->formatterOptions = $options;

        return $this;
    }

    /**
     * Echo message + matrix|array to screen
     *
     * @param string $msg
     * @param \Chippyash\Matrix\Matrix|array $aA
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
                ->display($this->formatterOptions)
             . PHP_EOL;

        echo $out;
    }

    /**
     * Get formatter - use default Ascii formatter if not set
     *
     * @return \Chippyash\Matrix\Interfaces\FormatterInterface
     */
    protected function getFormatter()
    {
        if (empty($this->formatter)) {
            $this->formatter = new Ascii();
        }

        return $this->formatter;
    }
}
