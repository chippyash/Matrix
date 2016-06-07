<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace Chippyash\Matrix\Vector;

use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Exceptions\VectorException;
use Zend\Stdlib\ArrayObject as ZArrayObject;

/**
 * A set of vectors
 */
class VectorSet extends ZArrayObject
{

    /**
     * Overide ancestor to disallow setting up of set from construction
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Add vector set entries from a Matrix
     *
     * @param \Chippyash\Matrix\Matrix $mA
     * @return \Chippyash\Matrix\Vector\VectorSet $this
     */
    public function fromMatrix(Matrix $mA)
    {
        $data = $mA->toArray();
        $rows = $mA->rows();
        $cols = $mA->columns();
        for ($y = 0; $y < $rows; $y++) {
            for ($x = 0; $x < $cols; $x++) {
                $this->append(new Vector2D($x, $y, $data[$y][$x]));
            }
        }

        return $this;
    }

    /**
     * Convert vector set to a matrix where row == y, col == x
     *
     * @param boolean $rebase Rebase vector entries to 0,0
     * @return \Chippyash\Matrix\Matrix
     */
    public function toMatrix($rebase = true)
    {
        $mArr = [];
        foreach ($this as $vector) {
            $mArr[$vector->getY()][$vector->getX()] = $vector->getValue();
        }

        if ($rebase) {
            return new Matrix($this->rebase($mArr));
        } else {
            return new Matrix($mArr);
        }
    }

    /**
     * Apply a translation function to each vector in the set
     * @see VectorSet::translate
     *
     * @param \callable $f
     * @return \Chippyash\Matrix\Vector\VectorSet $this
     */
    public function translate(callable $f)
    {
        foreach ($this as &$vector) {
            $vector->translate($f);
        }

        return $this;
    }

    /**
     * Only allow Vector2D objects to be appended
     *
     * @param \Chippyash\Matrix\Vector\Vector2D $value
     * @return \Chippyash\Matrix\Vector\VectorSet $this
     * @throws \Chippyash\Matrix\Exceptions\VectorException
     */
    public function append($value)
    {
        if (!$value instanceof Vector2D) {
            throw new VectorException('Append value is not a vector');
        }

        parent::append($value);

        return $this;
    }

    /**
     * Sort and rebase the result array to zero
     *
     * @param array $a
     * @return array
     */
    protected function rebase(array $a)
    {
        $res = [];
        ksort($a);
        foreach(array_values($a) as $row) {
            ksort($row);
            $res[] = array_values($row);
        }

        return $res;
    }
}
