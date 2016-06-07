<?php
namespace Chippyash\Test\Matrix\Traits;
use Chippyash\Matrix\Traits\AssertParameterIsMatrix;
use Chippyash\Matrix\Matrix;

class stubTraitAssertParameterIsMatrix
{
    use AssertParameterIsMatrix;

    public function test($param, $msg = null)
    {
        return (is_null($msg))
                ? $this->assertParameterIsMatrix($param)
                : $this->assertParameterIsMatrix($param, $msg);
    }
}

class AssertParameterIsMatrixTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new stubTraitAssertParameterIsMatrix();
    }

    public function testMatrixParamReturnsClass()
    {
        $this->assertInstanceOf(
                'Chippyash\Test\Matrix\Traits\stubTraitAssertParameterIsMatrix',
                $this->object->test(new Matrix([])));
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Parameter is not a matrix
     */
    public function testNotMatrixParamThrowsException()
    {
        $this->object->test('foo');
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage foo
     */
    public function testNotMatrixParamThrowsExceptionWithUserMessage()
    {
        $this->object->test('bar', 'foo');
    }
}
