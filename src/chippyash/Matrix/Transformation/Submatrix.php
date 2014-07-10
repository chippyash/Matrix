<?php

/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace chippyash\Matrix\Transformation;

use chippyash\Matrix\Transformation\AbstractTransformation;
use chippyash\Matrix\Matrix;
use chippyash\Matrix\Exceptions\MatrixException;
use chippyash\Matrix\Exceptions\UndefinedMatrixException;

/**
 * Return a matrix that is part of a matrix
 * This relies on code from the JAMA library
 * @link http://www.phpmath.com/build02/JAMA/downloads/
 * @todo complete all other cases
 */
class Submatrix extends AbstractTransformation
{


    /**
     *
     * @var Matrix
     */
    protected $mA;

    /**
     * Return a smaller part of a matrix
     *
     * The $extra array holds additional parameters.
     * @see Submatrix::getMatrix
     *
     * @param Matrix $mA First matrix operand - required
     * @param array $extra [submatrixParam,]
     *
     * @return Matrix
     *
     * @throws chippyash/Matrix/Exceptions/MatrixException
     */
    public function transform(Matrix $mA, $extra = null)
    {
        $c = count($extra);
        if ($c < 2 || $c > 4) {
            throw new MatrixException('Invalid number of parameters for submatrix operation');
        }

        $this->mA = $mA;

        return call_user_func_array($this->getMatrix(), $extra);
    }

    /**
     * getMatrix
     * Get a submatrix.  Polymorphic
     *
     * @param int|array $i0 Initial row index
     * @param int|array $iF Final row index
     * @param int|array $j0 Initial column index
     * @param int $jF Final column index
     *
     * @throws chippyash\Matrix\Exceptions\UndefinedMatrixException
     *
     * @return Matrix Submatrix
     */
    function getMatrix()
    {
        $args = func_get_args();
        $match = implode(",", array_map('gettype', $args));
        switch ($match) {

            //A($i0...; $j0...)
            case 'integer,integer':
                list($i0, $j0) = $args;
                $m = $i0 >= 0 ? $this->m - $i0 : trigger_error(ArgumentBoundsException, ERROR);
                $n = $j0 >= 0 ? $this->n - $j0 : trigger_error(ArgumentBoundsException, ERROR);
                $R = new Matrix($m, $n);

                for ($i = $i0; $i < $this->m; $i++)
                    for ($j = $j0; $j < $this->n; $j++)
                        $R->set($i, $j, $this->A[$i][$j]);

                return $R;
                break;

            //A($i0...$iF; $j0...$jF)
            case 'integer,integer,integer,integer':
                list($i0, $iF, $j0, $jF) = $args;
                $m = ( ($iF > $i0) && ($this->m >= $iF) && ($i0 >= 0) ) ? $iF - $i0 : trigger_error(ArgumentBoundsException, ERROR);
                $n = ( ($jF > $j0) && ($this->n >= $jF) && ($j0 >= 0) ) ? $jF - $j0 : trigger_error(ArgumentBoundsException, ERROR);
                $R = new Matrix($m + 1, $n + 1);

                for ($i = $i0; $i <= $iF; $i++)
                    for ($j = $j0; $j <= $jF; $j++)
                        $R->set($i - $i0, $j - $j0, $this->A[$i][$j]);

                return $R;
                break;

            //$R = array of row indices; $C = array of column indices
            case 'array,array':
                list($RL, $CL) = $args;
                $m = count($RL) > 0 ? count($RL) : trigger_error(ArgumentBoundsException, ERROR);
                $n = count($CL) > 0 ? count($CL) : trigger_error(ArgumentBoundsException, ERROR);
                $R = new Matrix($m, $n);

                for ($i = 0; $i < $m; $i++)
                    for ($j = 0; $j < $n; $j++)
                        $R->set($i - $i0, $j - $j0, $this->A[$RL[$i]][$CL[$j]]);

                return $R;
                break;

            //$RL = array of row indices; $CL = array of column indices
            case 'array,array':
                list($RL, $CL) = $args;
                $m = count($RL) > 0 ? count($RL) : trigger_error(ArgumentBoundsException, ERROR);
                $n = count($CL) > 0 ? count($CL) : trigger_error(ArgumentBoundsException, ERROR);
                $R = new Matrix($m, $n);

                for ($i = 0; $i < $m; $i++)
                    for ($j = 0; $j < $n; $j++)
                        $R->set($i, $j, $this->A[$RL[$i]][$CL[$j]]);

                return $R;
                break;

            //A($i0...$iF); $CL = array of column indices
            case 'integer,integer,array':
                list($i0, $iF, $CL) = $args;
                $m = ( ($iF > $i0) && ($this->m >= $iF) && ($i0 >= 0) ) ? $iF - $i0 : trigger_error(ArgumentBoundsException, ERROR);
                $n = count($CL) > 0 ? count($CL) : trigger_error(ArgumentBoundsException, ERROR);
                $R = new Matrix($m, $n);

                for ($i = $i0; $i < $iF; $i++)
                    for ($j = 0; $j < $n; $j++)
                        $R->set($i - $i0, $j, $this->A[$RL[$i]][$j]);

                return $R;
                break;

            //$RL = array of row indices
            case 'array,integer,integer':
                list($RL, $j0, $jF) = $args;
                if (($m = count($RL)) == 0) {
                    throw new MatrixException('row indices argument size == 0');
                }
                if (($jF >= $j0) && ($this->mA->columns() >= $jF) && ($j0 >= 0)) {
                    $n = $jF - $j0;
                } else {
                    throw new MatrixException('start and/or end parameters out of bounds');
                }

                //$R = new Matrix($m, $n + 1);
                $R = array_fill(0, $m, array_fill(0, $n+1, 0));

                for ($i = 0; $i < $m; $i++) {
                    for ($j = $j0; $j <= $jF; $j++) {
                        $R[$i][$j - $j0] = $this->mA->get($RL[$i],$j, false);
                    }
                }

                return new Matrix($R);
                break;
            default:
                throw new UndefinedMatrixException('No submatrix for supplied parameters');
                break;
        }
    }

}
