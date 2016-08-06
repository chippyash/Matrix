<?php
/**
 * Matrix
 *
 * @author Ashley Kitson
 * @copyright Ashley Kitson, 2016, UK
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */

namespace Chippyash\Test\Matrix\Traits;

use Chippyash\Matrix\Matrix;
use Chippyash\Matrix\Traits\Mutability;

class stubTraitMutabalityMatrix extends Matrix
{
    use Mutability;
}

class MutabilityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * System Under Test
     * @var stubTraitMutabalityMatrix
     */
    protected $sut;

    protected function setUp()
    {
        $this->sut = new stubTraitMutabalityMatrix(
            [
                [1, 2, 3],
                [4, 5, 6],
                [7, 8, 9]
            ]
        );
    }

    /**
     * @expectedException \Chippyash\Matrix\Exceptions\VerticeOutOfBoundsException
     * @expectedExceptionMessage Vertice 'row' is out of bounds with value: -1
     */
    public function testSetVerifiesOneBasedMatrixForRow()
    {
        $this->sut->set(-1, 1, 0);
    }

    /**
     * @expectedException \Chippyash\Matrix\Exceptions\VerticeOutOfBoundsException
     * @expectedExceptionMessage Vertice 'col' is out of bounds with value: -1
     */
    public function testSetVerifiesOneBasedMatrixForColumn()
    {
        $this->sut->set(1, -1, 0);
    }

    /**
     * @expectedException \Chippyash\Matrix\Exceptions\VerticeOutOfBoundsException
     * @expectedExceptionMessage Vertice 'row' is out of bounds with value: 4
     */
    public function testSetVerifiesUpperBoundaryOfMatrixForRow()
    {
        $this->sut->set(4, 1, 0);
    }

    /**
     * @expectedException \Chippyash\Matrix\Exceptions\VerticeOutOfBoundsException
     * @expectedExceptionMessage Vertice 'col' is out of bounds with value: 4
     */
    public function testSetVerifiesUpperBoundaryOfMatrixForColumn()
    {
        $this->sut->set(1, 4, 0);
    }

    /**
     * @expectedException \Chippyash\Matrix\Exceptions\VerticeOutOfBoundsException
     * @expectedExceptionMessage Vertice 'row & col' is out of bounds with value: 0
     */
    public function testSetErrorsIfBothParametersAreZero()
    {
        $this->sut->set(0, 0, 0);
    }

    public function testSetWillSetAnIncompleteVertex()
    {
        $this->sut = new stubTraitMutabalityMatrix(array(array(1, 2, 3), array(), array()));

        for ($c = 1; $c < 4; $c++) {
            for ($r = 2; $r < 4; $r++) {
                $this->sut->set($r, $c, 0);
            }
        }

        $this->assertEquals([[1,2,3],[0,0,0],[0,0,0]], $this->sut->toArray());
    }

    public function testSetReturnsMatrixOnSuccess()
    {
        $this->assertInstanceof('\Chippyash\Test\Matrix\Traits\stubTraitMutabalityMatrix', $this->sut->set(1, 1, 0));

    }

    public function testIfSettingAVectorYouMustProvideAMatrixAsTheDataParameter()
    {
        $this->setExpectedException('\Chippyash\Matrix\Exceptions\MatrixException');
        $this->sut->set(0,1,'foo');
        $this->setExpectedException('\Chippyash\Matrix\Exceptions\MatrixException');
        $this->sut->set(1,0,'foo');
    }

    /**
     * @expectedException \Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage $data for set method must be a column vector
     */
    public function testIfSettingAColumnVectorYouMustSupplyAColumnVectorMatrixAsTheDataParameter()
    {
        $this->sut->set(0,1, new Matrix([[1,2,3]]));
    }

    /**
     * @expectedException \Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage $data for set method must be a row vector
     */
    public function testIfSettingARowVectorYouMustSupplyARowVectorMatrixAsTheDataParameter()
    {
        $this->sut->set(1,0, new Matrix([[1],[2],[3]]));
    }

    public function testSetWillSetAColumnMatrixIfRowParameterIsZero()
    {
        $mA = $this->sut->set(0, 1, new Matrix([[0],[0],[0]]));
        $this->assertEquals([[0,2,3],[0,5,6],[0,8,9]], $this->sut->toArray());
        $this->assertInstanceOf('\Chippyash\Test\Matrix\Traits\stubTraitMutabalityMatrix', $mA);
    }

    public function testSetWillSetARowMatrixIfColumnParameterIsZero()
    {
        $mA = $this->sut->set(1, 0, new Matrix([[0,0,0]]));
        $this->assertEquals([[0,0,0],[4,5,6],[7,8,9]], $this->sut->toArray());
        $this->assertInstanceOf('\Chippyash\Test\Matrix\Traits\stubTraitMutabalityMatrix', $mA);
    }

    public function testSetWithTwoPositiveParametersWillSetAVertex()
    {
        $mA = $this->sut->set(2, 2, 0);
        $this->assertEquals([[1,2,3],[4,0,6],[7,8,9]], $this->sut->toArray());
        $this->assertInstanceOf('\Chippyash\Test\Matrix\Traits\stubTraitMutabalityMatrix', $mA);
    }
}
