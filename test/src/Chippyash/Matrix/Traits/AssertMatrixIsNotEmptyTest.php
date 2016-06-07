<?php
namespace Chippyash\Test\Matrix\Traits;
use Chippyash\Matrix\Traits\AssertMatrixIsNotEmpty;
use Chippyash\Matrix\Matrix;

class stubTraitAssertMatrixIsNotEmpty
{
    use AssertMatrixIsNotEmpty;

    public function test(Matrix $mA, $msg = null)
    {
        return (is_null($msg))
                ? $this->assertMatrixIsNotEmpty($mA)
                : $this->assertMatrixIsNotEmpty($mA, $msg);
    }
}

class AssertMatrixIsNotEmptyTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected $mA;
    protected $mB;

    protected function setUp()
    {
        $this->object = new stubTraitAssertMatrixIsNotEmpty();
        $this->mA = new Matrix([[1,2,3],[4,5,6],[7,8,9]]);
        $this->mB = new Matrix([]);
    }

    public function testNotEmptyMatrixReturnsClass()
    {
        $this->assertInstanceOf(
                'Chippyash\Test\Matrix\Traits\stubTraitAssertMatrixIsNotEmpty',
                $this->object->test($this->mA));
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix parameter is empty
     */
    public function testEmptyMatrixThrowsException()
    {
        $this->object->test($this->mB);
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage foo
     */
    public function testEmptyMatrixThrowsExceptionWithUserMessage()
    {
        $this->object->test($this->mB, 'foo');
    }
}
