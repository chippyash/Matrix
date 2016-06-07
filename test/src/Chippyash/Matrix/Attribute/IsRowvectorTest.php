<?php
namespace Chippyash\Test\Matrix\Attribute;
use Chippyash\Matrix\Attribute\IsRowvector;
use Chippyash\Matrix\Matrix;

/**
 */
class IsRowvectorTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new IsRowvector();
    }

    public function testSutHasAttributeInterface()
    {
        $this->assertInstanceOf(
                'Chippyash\Matrix\Interfaces\AttributeInterface',
                $this->object);
    }

    public function testEmptyMatrixIsNotARowVector()
    {
        $mA = new Matrix(array());
        $this->assertFalse($this->object->is($mA));
    }

    public function testSingleItemMatrixIsNotARowVector()
    {
        $mA = new Matrix(array(1));
        $this->assertFalse($this->object->is($mA));
    }

    public function testColumnVectorMatrixIsNotARowVector()
    {
        $mA = new Matrix(array(array(1),array(2),array(3)));
        $this->assertFalse($this->object->is($mA));
    }

    public function testRowVectorMatrixIsARowVector()
    {
        $mA = new Matrix(array(array(1,2,3)));
        $this->assertTrue($this->object->is($mA));
    }
}
