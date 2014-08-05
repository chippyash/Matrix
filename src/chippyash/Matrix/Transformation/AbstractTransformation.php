<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace chippyash\Matrix\Transformation;

use chippyash\Matrix\Interfaces\TransformationInterface;
use chippyash\Matrix\Exceptions\TransformationException;
use chippyash\Matrix\Matrix;

/**
 * Base abstract for transformation
 *
 * Has invokable interface
 */
abstract class AbstractTransformation implements TransformationInterface
{

    /**
     * @see TransformationInterface::transform
     * @abstract
     */
    public function transform(Matrix $mA, $extra = null)
    {
        return $this->returnOriginalMatrixType($mA, $this->doTransform($mA, $extra));
    }

    /**
     * Proxy to transform()
     * Allows object to be called as function
     *
     * @param Matrix $mA
     * @param mixed $extra Additional input required for transformation
     *
     * @return numeric
     *
     * @throws chippyash/Matrix/Exceptions/MatrixException
     */
    public function __invoke()
    {
        $numArgs = func_num_args();
        if ($numArgs == 1) {
            return $this->transform(func_get_arg(0));
        } elseif($numArgs == 2) {
            return $this->transform(func_get_arg(0), func_get_arg(1));
        } else {
            throw new TransformationException('Invoke method expects 0<n<3 arguments');
        }
    }

    /**
     * Required so that upstream matrices can use the transformations and be returned
     * in a matrix type they understand
     *
     * @param \chippyash\Matrix\Matrix $original
     * @param \chippyash\Matrix\Matrix $result
     * @return \chippyash\Matrix\Matrix
     */
    protected function returnOriginalMatrixType(Matrix $original, Matrix $result)
    {
        $oClass = get_class($original);
        if ($oClass == 'chippyash\Matrix\Matrix') {
            return $result;
        }

        return new $oClass($result);
    }

    /**
     * Do the actual transformation
     */
    abstract protected function doTransform(Matrix $mA, $extra = null);
}
