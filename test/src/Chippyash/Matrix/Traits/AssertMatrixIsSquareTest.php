<?php
namespace Chippyash\Test\Matrix\Traits;
use Chippyash\Matrix\Traits\AssertMatrixIsSquare;
use Chippyash\Matrix\Matrix;

class stubTraitAssertMatrixIsSquare
{
    use AssertMatrixIsSquare;

    public function test(Matrix $mA, $msg = null)
    {
        return (is_null($msg))
                ? $this->assertMatrixIsSquare($mA)
                : $this->assertMatrixIsSquare($mA, $msg);
    }
}

class AssertMatrixIsSquareTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected $mA;
    protected $mB;
    protected $mC;

    protected function setUp()
    {
        $this->object = new stubTraitAssertMatrixIsSquare();
        $this->mA = new Matrix([[1,2,3],[4,5,6],[7,8,9]]);
        $this->mB = new Matrix([1,2,3]);
        $this->mC = new Matrix([]);
        $this->mD = new Matrix([1]);
    }

    public function testSquareMatrixReturnsClass()
    {
        $this->assertInstanceOf(
                'Chippyash\Test\Matrix\Traits\stubTraitAssertMatrixIsSquare',
                $this->object->test($this->mA)); //filled
        $this->assertInstanceOf(
                'Chippyash\Test\Matrix\Traits\stubTraitAssertMatrixIsSquare',
                $this->object->test($this->mC)); //empty
        $this->assertInstanceOf(
                'Chippyash\Test\Matrix\Traits\stubTraitAssertMatrixIsSquare',
                $this->object->test($this->mD)); //single item
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix is not square
     */
    public function testNonSquareMatrixThrowsException()
    {
        $this->object->test($this->mB);
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage foo
     */
    public function testNonSquareMatrixThrowsExceptionWithUserMessage()
    {
        $this->object->test($this->mB, 'foo');
    }
}
