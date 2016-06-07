<?php
namespace Chippyash\Test\Matrix\Traits;
use Chippyash\Matrix\Traits\AssertParameterIsArray;

class stubTraitAssertParameterIsArray
{
    use AssertParameterIsArray;

    public function test($param, $msg = null)
    {
        return (is_null($msg))
                ? $this->assertParameterIsArray($param)
                : $this->assertParameterIsArray($param, $msg);
    }
}

class AssertParameterIsArrayTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new stubTraitAssertParameterIsArray();
    }

    public function testArrayParamReturnsClass()
    {
        $this->assertInstanceOf(
                'Chippyash\Test\Matrix\Traits\stubTraitAssertParameterIsArray',
                $this->object->test([]));
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Parameter is not an array
     */
    public function testNotArrayParamThrowsException()
    {
        $this->object->test('foo');
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage foo
     */
    public function testNotArrayParamThrowsExceptionWithUserMessage()
    {
        $this->object->test('bar', 'foo');
    }
}
