<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace chippyash\Matrix;

use chippyash\Matrix\Exceptions\NotCompleteMatrixException;
use chippyash\Matrix\Exceptions\VerticeOutOfBoundsException;
use chippyash\Matrix\Exceptions\VerticeNotFoundException;
use chippyash\Matrix\Exceptions\FormatterNotSetException;
use chippyash\Matrix\Exceptions\NotAnAttributeInterfaceException;
use chippyash\Matrix\Interfaces\TransformationInterface;
use chippyash\Matrix\Interfaces\FormatterInterface;
use chippyash\Matrix\Interfaces\AttributeInterface;
use chippyash\Matrix\Interfaces\InvokableInterface;

/**
 * Matrices are specialised arrays (in PHP terms)
 * A matrix has minimum of zero vectors (zero entries) [[]] === an empty matrix.
 *
 * For our purposes a matrix has rows (R)
 * corresponding to a negative Y axis and columns (C) corresponding to the X axis  e.g.
 * [1, 2, 3] == 1 row and 3 columns == matrix[R=1, C=3]. Vectors = 3
 * [
 *   [1, 2, 3]
 *   [1, 2, 3]
 * ]  == 2 rows and 3 columns == matrix[R=2, C=3]. Vectors = 6
 * The number of vectors contained in a matrix = rows * columns (R*C)
 *
 * A complete matrix has same number of columns in each row i.e. C(R1) == C(Rn)
 *
 * A square matrix has all vertices filled and R == C
 *
 * A Row Vector is a matrix[R=1, C>1]
 * A Column Vector is a matrix[R>1, C=1]
 *
 * Matrices are addressed as 1 based arrays i.e R=1..N, C=1..N. A matrix address
 * (vertice) is expressed as the name of the matrix and a subscript suffix of
 * row,column i.e. Mr,c e.g. M1,1, M3,4
 * If a matrix is called M, with R rows and C columns then:
 * - the entry at the intersection of the first row and first column is M1,1
 * - the entry at the intersection of last row and last column is MR,C
 *
 * Matrices are immutable, they cannot be changed internally.  Hence no set() method.
 *
 */
class Matrix implements InvokableInterface
{
    /**
     * Namespaces for this library
     */
    const NS = 'chippyash\Matrix';
    const NS_TRANSFORMATION = 'chippyash\Matrix\Transformation\\';
    const NS_ATTRIBUTE = 'chippyash\Matrix\Attribute\Is';

    /**
     * Error messages
     */
    const ERR_INVALID_OP_NAME = 'Invalid operation name';
    const ERR_INVALID_INVOKE_ARG = 'Invalid number of arguments to invoke method';

    /**
     * Data for this matrix
     * @var array
     */
    protected $data = [[]];

    /**
     * @var chippyash\Matrix\Formatter\FormatterInterface
     */
    protected $formatter;

    /**
     * Create a matrix, forcing completeness if required and filling in (normalizing)
     * missing vertices if required.
     *
     * @param array $source Array to initialise the matrix with
     * @param boolean $complete Check that matrix is X(Y1) == X(Yn)
     * @param boolean $normalize Normalize matrix by setting missing vertices
     * @param mixed $normalizeDefault Value to set missing vertices to if normalizing
     *
     * @throws \chippyash\Matrix\Exceptions\NotCompleteMatrixException
     */
    public function __construct(array $source, $complete = false, $normalize= false, $normalizeDefault = null)
    {
        if (empty($source) || $source == [[]]) {
            $this->reset();
        } elseif (!is_array($source[0])) {
            $this->store(array($source));
        } else {
            $this->store($source);
        }

        if ($normalize) {
            $this->normalize($normalizeDefault);
        }

        if ($complete ) {
            $this->enforceCompleteness();
        }

    }

    /**
     * Get the matrix as an Array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * How many rows in the matrix?
     *
     * @return int
     */
    public function rows()
    {
        if ($this->is('empty')) {
            return 0;
        }
        return count($this->data);
    }

    /**
     * How many columns?
     * NB if you have an incomplete array, this could be wrong. i.e. we test
     * number of entries in the first row only.  To be sure either enforce
     * completeness in construction or test using is('complete')
     *
     * @return int
     */
    public function columns()
    {
        if ($this->is('empty')) {
            return 0;
        }
        return count($this->data[0]);
    }

    /**
     * How many vertices (or entries)
     * See comments for columns()
     *
     * @return int
     */
    public function vertices()
    {
        return ($this->rows() * $this->columns());
    }

    /**
     * Get a matrix vertice (entry) value
     *
     * @param int $row >= 1
     * @param int $col >= 1
     *
     * @return mixed
     *
     * @throws VerticeOutOfBoundsException
     * @throws VerticeNotFoundException
     */
    public function get($row, $col)
    {
        if ($row < 1 || $row > $this->rows()) {
            throw new VerticeOutOfBoundsException('row', $row);
        }
        if ($col < 1 || $col > $this->columns()) {
            throw new VerticeOutOfBoundsException('col', $col);
        }
        if (!isset($this->data[$row-1][$col-1])) {
            throw new VerticeNotFoundException($row, $col);
        }

        return $this->data[$row-1][$col-1];
    }

    /**
     * Does this matrix have a particular attribute
     * Bound to Attributes in chippyash/Matrix/Attribute
     * If attribute does not exist - will return false. If you need to trap this
     * use test() method instead
     *
     * @param string $attribute Name of attribute to test for (do not include 'is' prefix)
     *
     * @return boolean
     */
    public function is($attribute)
    {
        try {
            return $this->test($attribute);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Raw form of is() method. You can use this to test for attributes
     * not supplied with the library by passing in $attribute conforming to
     * AttributeInterface.  If it's something you think is important , consider
     * contributing it to the library.
     *
     * @param string|AttributeInterface $attribute
     *
     * @return boolean
     *
     * @throws NotAnAttributeInterfaceException
     * @throws \BadMethodCallException
     */
    public function test($attribute)
    {
        if (is_string($attribute)) {
            $attribute = ucfirst(strtolower($attribute));
            $class = self::NS_ATTRIBUTE. $attribute;
            if (class_exists($class)) {
                $obj = new $class();
            } else {
                throw new \BadMethodCallException();
            }
        } else {
            $obj = $attribute;
        }

        if (!$obj instanceof AttributeInterface) {
            throw new NotAnAttributeInterfaceException(get_class($obj));
        }

        return $obj->is($this);
    }

    /**
     * Carry out a transformation with this matrix as first argument and an
     * optional second argument
     *
     * @param \chippyash\Matrix\Interfaces\TransformationInterface $transformation
     * @param mixed $extra
     * @return \chippyash\Matrix\Matrix
     */
    public function transform(TransformationInterface $transformation, $extra = null)
    {
        return $transformation->transform($this, $extra);
    }

    /**
     * Invokable interface - allows object to be called as function
     * Proxies to transform e.g.
     * $matrix("Rowslice", array(1,2))
     *
     * @param string $operationName Name of operation to perform
     * @param mixed $extra Additional parameter required by the operation
     *
     * @return \chippyash\Matrix\Matrix
     *
     * @throws \InvalidArgumentException
     */
    public function __invoke()
    {
        //argument arbitrage
        $numArgs = func_num_args();
        if ($numArgs == 1) {
            $operationName = func_get_arg(0);
            $extra = null;
        } elseif($numArgs == 2) {
            $operationName = func_get_arg(0);
            $extra = func_get_arg(1);
        } else {
            throw new \InvalidArgumentException(self::ERR_INVALID_INVOKE_ARG);
        }

        $tName = self::NS_TRANSFORMATION . $operationName;
        if (class_exists($tName, true)) {
            return $this->transform(new $tName(), $extra);
        }

        //else
        throw new \InvalidArgumentException(self::ERR_INVALID_OP_NAME);
    }

    /**
     * Set display formatter
     *
     * @param \chippyash\Matrix\Formatter\FormatterInterface $formatter
     * @return \chippyash\Matrix\Matrix Fluent Interface
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        $this->formatter = $formatter;

        return $this;
    }

    /**
     * Return the matrix in some displayable format
     *
     * @param array $options Options for the formatter
     *
     * @return mixed
     * @throws FormatterNotSetException
     */
    public function display(array $options = array())
    {
        if (empty($this->formatter)) {
            throw new FormatterNotSetException();
        }

        return $this->formatter->format($this, $options);
    }

    /**
     * Store the data
     *
     * @param array $data
     *
     * @return void
     */
    protected function store(array $data)
    {
        $this->data = $data;
    }

    /**
     * Reset the matrix to empty
     */
    protected function reset()
    {
        $this->data = [[]];
    }

    /**
     * Test for matrix completeness
     *
     * @return boolean
     *
     * @throws chippyash\Matrix\Exceptions\NotCompleteMatrixException
     */
    protected function enforceCompleteness()
    {
        //empty matrix is ok
        if ($this->is('empty')) {
            return;
        }
        //check that each row has same number of columns
        $numcols = count($this->data[0]);
        array_walk(
                $this->data,
                function($value, $index, $matchCols) {
                    if (count($value) != $matchCols) {
                        throw new NotCompleteMatrixException($index);
                    }
                },
                $numcols);
    }

    /**
     * Normalize matrix to have same number of columns for each row
     * Missing vertices are set with default value
     *
     * @param mixed $default default value to set
     */
    protected function normalize($default)
    {
        if ($this->is('empty')) {
            return;
        }

        $maxCols = array_reduce(
                $this->data,
                function($carry, $item) {
                    $l = count($item);
                    return ($l > $carry ? $l : $carry);
                },
                0);

        array_walk(
                $this->data,
                function(&$row) use ($maxCols, $default) {
                    if (($len = count($row)) < $maxCols) {
                        $row += array_fill($len, $maxCols - $len, $default);
                    }
                });
    }
}
