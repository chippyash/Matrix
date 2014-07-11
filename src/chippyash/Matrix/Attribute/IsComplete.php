<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 * @link http://en.wikipedia.org/wiki/Matrix_(mathematics)
 */
namespace chippyash\Matrix\Attribute;

use chippyash\Matrix\Interfaces\AttributeInterface;
use chippyash\Matrix\Matrix;

/**
 * Complete attribute - this means that all vertices have a value
 * Empty matrices are complete
 * You can call getErrRow() if not complete to get the first row that was not complete
 */
class IsComplete implements AttributeInterface
{
    /**
     * Row that was in error
     *
     * @var int
     */
    protected $errRow = null;

    /**
     * Does the matrix have this attribute
     *
     * @param Matrix $mA
     * @return boolean
     */
    public function is(Matrix $mA)
    {
        //empty matrix is ok
        if ($mA->is('empty')) {
            return true;
        }
        $data = $mA->toArray();

        //check we don't have empty/missing rows
        $tmp = array_keys($data); //to get past error_reporting E_STRICT for Travis
        $top = array_pop($tmp);
        if ($top >= count($data)) {
            $this->errRow = count($data);
            return false;
        }

        //check that each row has same number of columns
        $numcols = count($data[0]);
        $ret = true;
        $r = 0;
        array_walk(
                $data,
                function($value, $index, $matchCols) use (&$ret, &$r) {
                    if ($ret && (count($value) != $matchCols)) {
                        $ret = false;
                        $r = $index;
                    }
                },
                $numcols);

        if (!$ret) {
            $this->errRow = $r + 1;
        }

        return $ret;
    }

    /**
     * Row number in error
     *
     * @return null|int
     */
    public function getErrRow()
    {
        return $this->errRow;
    }
}
