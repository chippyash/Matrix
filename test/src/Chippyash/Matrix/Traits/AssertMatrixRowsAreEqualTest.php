<?php
namespace Chippyash\Test\Matrix\Traits;
use Chippyash\Matrix\Traits\AssertMatrixRowsAreEqual;
use Chippyash\Matrix\Matrix;

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

    public function testEqualRowsReturnsClass()
    {
        $this->assertInstanceOf(
                'Chippyash\Test\Matrix\Traits\stubTraitAssertMatrixRowsAreEqual',
                $this->object->test($this->mA, $this->mA));
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage mA->rows != mB->rows
     */
    public function testUnequalRowsThrowsException()
    {
        $this->object->test($this->mA, $this->mB);
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage foo
     */
    public function testUnequalRowsThrowsExceptionWithUserMessage()
    {
        $this->object->test($this->mA, $this->mB, 'foo');
    }
}
