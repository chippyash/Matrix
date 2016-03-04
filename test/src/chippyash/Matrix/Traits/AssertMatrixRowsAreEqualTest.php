<?php
namespace chippyash\Test\Matrix\Traits;
use chippyash\Matrix\Traits\AssertMatrixRowsAreEqual;
use chippyash\Matrix\Matrix;

class stubTraitAssertMatrixRowsAreEqual
{
    use AssertMatrixRowsAreEqual;

    public function test(Matrix $mA, Matrix $mB, $msg = null)
    {
        return (is_null($msg))
                ? $this->assertMatrixRowsAreEqual($mA, $mB)
                : $this->assertMatrixRowsAreEqual($mA, $mB, $msg);
    }
}

class AssertMatrixRowsAreEqualTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected $mA;
    protected $mB;

    protected function setUp()
    {
        $this->object = new stubTraitAssertMatrixRowsAreEqual();
        $this->mA = new Matrix([[1,2,3],[4,5,6],[7,8,9]]);
        $this->mB = new Matrix([[1,2,3],[4,5,6]]);
    }

    /**
     * @covers chippyash\Matrix\Traits\AssertMatrixRowsAreEqual::assertMatrixRowsAreEqual
     */
    public function testEqualRowsReturnsClass()
    {
        $this->assertInstanceOf(
                'chippyash\Test\Matrix\Traits\stubTraitAssertMatrixRowsAreEqual',
                $this->object->test($this->mA, $this->mA));
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage mA->rows != mB->rows
     * @covers chippyash\Matrix\Traits\AssertMatrixRowsAreEqual::assertMatrixRowsAreEqual
     */
    public function testUnequalRowsThrowsException()
    {
        $this->object->test($this->mA, $this->mB);
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage foo
     * @covers chippyash\Matrix\Traits\AssertMatrixRowsAreEqual::assertMatrixRowsAreEqual
     */
    public function testUnequalRowsThrowsExceptionWithUserMessage()
    {
        $this->object->test($this->mA, $this->mB, 'foo');
    }
}
