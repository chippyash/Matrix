<?php

/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace Chippyash\Matrix\Formatter;

use Chippyash\Matrix\Interfaces\FormatterInterface;
use Chippyash\Matrix\Matrix;

/**
 * Format matrix as an ascii diagram
 */
class Ascii implements FormatterInterface
{

    protected $options = array(
        'padLine' => 1,
        'padString' => ' ',
        'padType' => STR_PAD_LEFT,
        'lineEnd' => PHP_EOL,
        'boxHorizChar' => '-',
        'boxVertChar' => '|',
        'boxTopLeftChar' => '+',
        'boxTopRightChar' => '+',
        'boxBotLeftChar' => '+',
        'boxBotRightChar' => '+',
    );

    /**
     * Format the matrix contents for outputting
     *
     * @param Matrix $mA Matrix to format
     * @param array $options Options for formatter
     *
     * @return string
     */
    public function format(Matrix $mA, array $options = array())
    {
        $this->setOptions($options);
        //cast incoming matrix to base matrix to ensure compatibility with the formatter
        $output = $this->box(
                $this->getLines(
                        $this->convert(
                                new Matrix($mA->toArray())
                        )
                )
        );

        return $output;
    }

    /**
     * Set formatting options
     *
     * @param array $options
     */
    protected function setOptions(array $options = array())
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Create a matrix with padded string values
     *
     * @param \Chippyash\Matrix\Matrix $mA
     * @return \Chippyash\Matrix\Matrix
     */
    protected function convert(Matrix $mA)
    {
        //get largest value length as a string
        $padLen = 0;
        /** @noinspection PhpUnusedParameterInspection */
        /** @noinspection PhpDocSignatureInspection */
        /** @noinspection PhpDocSignatureInspection */
        $fGetLen = function($row, $col, $value) use(&$padLen) {
            if (is_bool($value)) {
                $value = ($value ? 1 : 0);
            }
            $l = strlen((string) $value);
            if ($l > $padLen) {
                $padLen = $l;
            }
            return $value;
        };
        $mA("MFunction", $fGetLen);

        //pad out each value
        $padLen += $this->options['padLine'];
        $padString = $this->options['padString'];
        $padType = $this->options['padType'];
        /** @noinspection PhpUnusedParameterInspection */
        /** @noinspection PhpDocSignatureInspection */
        /** @noinspection PhpDocSignatureInspection */
        $fConvert = function($row, $col, $value) use ($padLen, $padString, $padType) {
            if (is_bool($value)) {
                $value = ($value ? 1 : 0);
            }
            return str_pad($value, $padLen, $padString, $padType);
        };

        $mC = $mA("MFunction", $fConvert);

        return $mC;
    }

    /**
     * Covert each row of matrix into a line
     *
     * @param \Chippyash\Matrix\Matrix $mA
     * @return array
     */
    protected function getLines(Matrix $mA)
    {
        $lines = array();
        $data = $mA->toArray();
        $rows = $mA->rows();
        $cols = $mA->columns();
        for ($row = 0; $row < $rows; $row++) {
            $line = '';
            for ($col = 0; $col < $cols; $col++) {
                $line .= $data[$row][$col];
            }
            $lines[$row] = $line;
        }

        return $lines;
    }

    /**
     * Create output with box around matrix 
     *
     * @param array $lines
     * @return string
     */
    protected function box(array $lines)
    {
        if (count($lines) > 0) {
            $width = strlen($lines[0]);
        } else {
            $width = 0;
        }
        $head = $this->options['boxTopLeftChar']
                . str_pad('', $width, $this->options['boxHorizChar'])
                . $this->options['boxTopRightChar']
                . $this->options['lineEnd'];
        $tail = $this->options['boxBotLeftChar']
                . str_pad('', $width, $this->options['boxHorizChar'])
                . $this->options['boxBotRightChar']
                . $this->options['lineEnd'];
        $output = '';
        foreach ($lines as $line) {
            $output .= $this->options['boxVertChar']
                    . $line
                    . $this->options['boxVertChar']
                    . $this->options['lineEnd'];
        }

        return $head . $output . $tail;
    }

}
