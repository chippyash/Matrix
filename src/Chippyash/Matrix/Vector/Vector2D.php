<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace Chippyash\Matrix\Vector;

use Chippyash\Matrix\Exceptions\VectorException;
use Chippyash\Matrix\Matrix;

/**
 * A 2D vector
 */
class Vector2D
{

    /**
     * X coord
     * @var float|integer
     */
    protected $x;
    /**
     * Y coord
     * @var float|integer
     */
    protected $y;

    /**
     * Value of the vector
     * @var mixed
     */
    protected $value;

    /**
     * Construct a vector
     *
     * @param float|int $x - corresponds to matrix columns
     * @param float|int $y - corresponds to matrix rows
     * @param mixed $value - value of vector
     *
     * @throws VectorException
     */
    public function __construct($x = 0, $y = 0, $value = null)
    {
        if (!is_numeric($x)) {
            throw new VectorException('X is not numeric');
        }
        if (!is_numeric($y)) {
            throw new VectorException('Y is not numeric');
        }

        $this->x = $x;
        $this->y = $y;
        $this->value = $value;
    }

    /**
     * Convert coords to Column Vector Matrix
     *
     * @return \Chippyash\Matrix\Matrix
     * @throws VectorException
     */
    public function toColVectorMatrix()
    {
        return new Matrix([[$this->y],[$this->x]]);
    }

    /**
     * Return X coord
     * @return float|integer
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Return Y coord
     * @return float|integer
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Return vector value
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Translate (mutate) this vector using a function
     * function $f($x, $y, $value) {return [$newX, $newY, $newValue];}
     *
     * @param \callable $f
     * @throws VectorException
     * @returns $this
     */
    public function translate(callable $f)
    {
        list($this->x, $this->y, $this->value) = $f($this->x, $this->y, $this->value);
    }

    /**
     * Return string representation of vector coords in 'x,y'
     *
     * @return string
     */
    public function __toString()
    {
        return "{$this->x},{$this->y}";
    }

    /**
     * Return string representation of vector coords in 'y,x' format format
     * i.e. familiar to matrix users used to row, column vertices
     *
     * @return string
     */
    public function toYXString()
    {
        return "{$this->y},{$this->x}";
    }
}
