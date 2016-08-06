<?php
/**
 * Matrix
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2016, UK
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Matrix\Traits;

use Chippyash\Matrix\Exceptions\MatrixException;
use Chippyash\Matrix\Exceptions\VerticeOutOfBoundsException;
use Chippyash\Matrix\Matrix;

/**
 * Trait Mutability
 * Adds mutability to matrices for those situations where you need it
 */
trait Mutability
{
    /**
     * Set a matrix vertex, row or column vector
     * If row == 0 && col > 0, then set the column vector indicated by col
     * If col == 0 && row > 0, then set the row vector indicated by row
     * if row > 0 && col > 0, set the vertex
     * row == col == 0 is an error
     *
     * @param int $row
     * @param int $col
     * @param mixed|Matrix $data If setting a vector, supply the correct vector matrix
     *
     * @return Matrix
     * @throws VerticeOutOfBoundsException
     * @throws MatrixException
     */
    public function set($row, $col, $data)
    {
        if ($row < 0 || $row > $this->rows()) {
            throw new VerticeOutOfBoundsException('row', $row);
        }
        if ($col < 0 || $col > $this->columns()) {
            throw new VerticeOutOfBoundsException('col', $col);
        }
        if ($row == 0 && $col == 0) {
            throw new VerticeOutOfBoundsException('row & col', 0);
        }

        if (($row == 0 || $col == 0) && !$data instanceof Matrix) {
            throw new MatrixException('$data for set method must be a matrix');
        }

        if ($row == 0 && $col > 0) {
            if (!$data->is('columnvector')) {
                throw new MatrixException('$data for set method must be a column vector');
            }
            $dArr = $data->toArray();
            $col --;
            for ($n = 0; $n < $this->rows(); $n ++) {
                $this->data[$n][$col] = $dArr[$n][0];
            }
            return $this;
        }

        if ($col == 0 && $row > 0) {
            if (!$data->is('rowvector')) {
                throw new MatrixException('$data for set method must be a row vector');
            }
            $dArr = $data->toArray();
            $row --;
            for ($m = 0; $m < $this->columns(); $m ++) {
                $this->data[$row][$m] = $dArr[0][$m];
            }
            return $this;
        }

        $this->data[$row-1][$col-1] = $data;

        return $this;
    }

}