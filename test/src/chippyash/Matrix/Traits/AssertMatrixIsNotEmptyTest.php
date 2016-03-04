<?php
namespace chippyash\Test\Matrix\Traits;
use chippyash\Matrix\Traits\AssertMatrixIsNotEmpty;
use chippyash\Matrix\Matrix;

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

    /**
     * @covers chippyash\Matrix\Traits\AssertMatrixIsNotEmpty::assertMatrixIsNotEmpty
     */
    public function testNotEmptyMatrixReturnsClass()
    {
        $this->assertInstanceOf(
                'chippyash\Test\Matrix\Traits\stubTraitAssertMatrixIsNotEmpty',
                $this->object->test($this->mA));
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Matrix parameter is empty
     * @covers chippyash\Matrix\Traits\AssertMatrixIsNotEmpty::assertMatrixIsNotEmpty
     */
    public function testEmptyMatrixThrowsException()
    {
        $this->object->test($this->mB);
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage foo
     * @covers chippyash\Matrix\Traits\AssertMatrixIsNotEmpty::assertMatrixIsNotEmpty
     */
    public function testEmptyMatrixThrowsExceptionWithUserMessage()
    {
        $this->object->test($this->mB, 'foo');
    }
}
