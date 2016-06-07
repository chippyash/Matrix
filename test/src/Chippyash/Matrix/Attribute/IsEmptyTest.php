<?php
namespace Chippyash\Test\Matrix\Attribute;
use Chippyash\Matrix\Attribute\IsEmpty;
use Chippyash\Matrix\Matrix;

/**
 */
class IsEmptyTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new IsEmpty();
    }

    public function testSutHasAttributeInterface()
    {
        $this->assertInstanceOf(
                'Chippyash\Matrix\Interfaces\AttributeInterface',
                $this->object);
    }

    public function testEmptyMatrixReturnsTrue()
    {
        $mA = new Matrix([]);
        $this->assertTrue($this->object->is($mA));
    }

    public function testNonEmptyMatrixReturnsFalse()
    {
        $mA = new Matrix([1]);
        $this->assertFalse($this->object->is($mA));
    }

}
