<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Matrix\Transformation;

use Chippyash\Matrix\Interfaces\TransformationInterface;
use Chippyash\Matrix\Exceptions\TransformationException;
use Chippyash\Matrix\Matrix;

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
     * @param Matrix $mA
     * @param null $extra
     * @return Matrix
     */
    public function transform(Matrix $mA, $extra = null)
    {
        return $this->returnOriginalMatrixType($mA, $this->doTransform($mA, $extra));
    }

    /**
     * Proxy to transform()
     * Allows object to be called as function
     * 
     * @return float|integer
     * 
     * @throws TransformationException
     * 
     * @internal param Matrix $mA
     * @internal param mixed $extra Additional input required for transformation
     *
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
     * @param Matrix $original
     * @param Matrix $result
     * 
     * @return Matrix
     */
    protected function returnOriginalMatrixType(Matrix $original, Matrix $result)
    {
        $oClass = get_class($original);
        if ($oClass == 'Chippyash\Matrix\Matrix') {
            return $result;
        }

        return new $oClass($result->toArray());
    }

    /**
     * Do the actual transformation
     * 
     * @param Matrix $mA
     * @param null $extra
     * 
     */
    abstract protected function doTransform(Matrix $mA, $extra = null);
}
