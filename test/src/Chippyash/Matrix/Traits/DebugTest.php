<?php
namespace Chippyash\Test\Matrix\Traits;
use Chippyash\Matrix\Traits\Debug;
use Chippyash\Matrix\Matrix;

class stubTraitDebug
{
    use Debug;

    public function test($msg, $matOrArr)
    {
        return $this->debug($msg, $matOrArr);
    }

    public function testSetFormatter($f)
    {
        return $this->setFormatter($f);
    }
}

class DebugTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new stubTraitDebug();
    }

    public function testArrayParamReturnsStringWithDebugSwitchedOn()
    {
        $test = "/foo\+.*\+/";
        $this->object->setDebug();
        ob_start();
        $this->object->test('foo', [[1]]);
        $res = str_replace(PHP_EOL, '', ob_get_clean());
        $this->assertRegExp($test, $res);
    }

    public function testMatrixParamReturnsStringWithDebugSwitchedOn()
    {
        $test = "/foo\+.*\+/";
        $this->object->setDebug();
        ob_start();
        $this->object->test('foo', New Matrix([1]));
        $res = str_replace(PHP_EOL, '', ob_get_clean());
        $this->assertRegExp($test, $res);
    }

    public function testArrayOrMatrixReturnsNothingWithDebugSwitchOff()
    {
        ob_start();
        $this->object->test('foo', [[1]]);
        $this->assertEmpty(ob_get_clean());
        ob_start();
        $this->object->test('foo', New Matrix([1]));
        $this->assertEmpty(ob_get_clean());
    }

    public function testSetFormatterReturnsObject()
    {
        $f = new \Chippyash\Matrix\Formatter\Ascii();
        $this->assertInstanceOf(
                'Chippyash\Test\Matrix\Traits\stubTraitDebug',
                $this->object->testSetFormatter($f, []));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Debug parameter is not an array or a matrix
     */
    public function testDebugWithInvalidParamThrowsException()
    {
        $this->object->setDebug();
        $this->object->test('foo', New \stdClass);
    }
}
