<?php
namespace chippyash\Test\Matrix\Computation;
use chippyash\Matrix\Matrix;

/**
 *
 * @author akitson
 */
class AbstractTransformationTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = $this->getMockForAbstractClass('chippyash\Matrix\Transformation\AbstractTransformation');
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Invoke method expects 0<n<3 arguments
     */
    public function testInvokeExpectsAtLeastOneArgument()
    {
        $f = $this->object;
        $f();
    }

    /**
     * @expectedException chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Invoke method expects 0<n<3 arguments
     */
    public function testInvokeExpectsLessThanThreeArguments()
    {
        $f = $this->object;
        $f('foo','bar','baz');
    }

    public function testInvokeCanAcceptTwoArguments()
    {
        $f = $this->object;
        $f(new Matrix(array()),'bar');
    }

    /**
     * @covers chippyash\Matrix\Transformation\AbstractTransformation::__invoke
     */
    public function testInvokeProxiesToCompute()
    {
        $this->object->expects($this->any())
                ->method('transform')
                ->will($this->returnValue(new Matrix(['foo'])));
        $f = $this->object;
        $m = new Matrix(array());
        $this->assertInstanceOf('chippyash\Matrix\Matrix', $f($m));
        $this->assertEquals(array(array('foo')), $f($m)->toArray());
    }
}
