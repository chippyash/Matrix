<?php
namespace Chippyash\Test\Matrix\Traits;
use Chippyash\Matrix\Traits\AssertMatrixIsComplete;
use Chippyash\Matrix\Matrix;

class stubTraitAssertMatrixIsComplete
{
    use AssertMatrixIsComplete;

    public function test(Matrix $mA, $msg = null)
    {
        return (is_null($msg))
                ? $this->assertMatrixIsComplete($mA)
                : $this->assertMatrixIsComplete($mA, $msg);
    }
}

class AssertMatrixIsCompleteTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected $mA;
    protected $mB;

    protected function setUp()
    {
        $this->object = new stubTraitAssertMatrixIsComplete();
        $this->mA = new Matrix([[1,2,3],[4,5,6],[7,8,9]]);
        $this->mB = new Matrix([[1,2,3],[4,5],[7]]);
    }

    public function testCompleteMatrixReturnsClass()
    {
        $this->assertInstanceOf(
                'Chippyash\Test\Matrix\Traits\stubTraitAssertMatrixIsComplete',
                $this->object->test($this->mA));
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix is not complete in row 2
     */
    public function testIncompleteMatrixThrowsException()
    {
        $this->object->test($this->mB);
    }

}
