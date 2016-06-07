<?php
namespace Chippyash\Test\Matrix\Computation;
use Chippyash\Matrix\Matrix;

class stubDescendentMatrix extends Matrix{}

/**
 *
 * @author akitson
 */
class AbstractTransformationTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = $this->getMockForAbstractClass('Chippyash\Matrix\Transformation\AbstractTransformation');
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Invoke method expects 0<n<3 arguments
     */
    public function testInvokeExpectsAtLeastOneArgument()
    {
        $f = $this->object;
        $f();
    }

    /**
     * @expectedException Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Invoke method expects 0<n<3 arguments
     */
    public function testInvokeExpectsLessThanThreeArguments()
    {
        $f = $this->object;
        $f('foo','bar','baz');
    }

    public function testInvokeCanAcceptTwoArguments()
    {
        $this->object->expects($this->any())
                ->method('doTransform')
                ->will($this->returnValue(new Matrix(['foo'])));
        $f = $this->object;
        $f(new Matrix(array()),'bar');
    }

    public function testInvokeProxiesToCompute()
    {
        $this->object->expects($this->any())
                ->method('doTransform')
                ->will($this->returnValue(new Matrix(['foo'])));
        $f = $this->object;
        $m = new Matrix(array());
        $this->assertInstanceOf('Chippyash\Matrix\Matrix', $f($m));
        $this->assertEquals(array(array('foo')), $f($m)->toArray());
    }

    public function testDescendentMatricesAreReturnedWithCorrectClass()
    {
        $stub = new stubDescendentMatrix([2]);
        $this->object->expects($this->any())
                ->method('doTransform')
                ->will($this->returnValue(new Matrix(['foo'])));
        $f = $this->object;
        $this->assertInstanceOf('Chippyash\Test\Matrix\Computation\stubDescendentMatrix', $f($stub));
    }
}
