<?php
namespace chippyash\Test\Matrix\Attribute;
use chippyash\Matrix\Attribute\IsDiagonal;
use chippyash\Matrix\Matrix;

/**
 */
class IsDiagonalTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new IsDiagonal();
    }

    public function testSutHasAttributeInterface()
    {
        $this->assertInstanceOf(
                'chippyash\Matrix\Interfaces\AttributeInterface',
                $this->object);
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsDiagonal::is()
     */
    public function testNonCompleteDiagonalMatrixReturnsFalse()
    {
        $testBad = array(array(1,0,0), array(0,0), array(0));
        $mA = new Matrix($testBad);
        $this->assertFalse($this->object->is($mA));
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsDiagonal::is()
     */
    public function testNonSquareMatrixReturnsFalse()
    {
        $testBad = array(array(1,0,2));
        $mA = new Matrix($testBad);
        $this->assertFalse($this->object->is($mA));
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsDiagonal::is()
     */
    public function testDiagonalMatrixReturnsTrue()
    {
        $testGood = array(array(1,0,0),array(0,1,0),array(0,0,1));
        $mA = new Matrix($testGood);
        $this->assertTrue($this->object->is($mA));
    }

    /**
     * @covers chippyash\Matrix\Attribute\IsDiagonal::is()
     */
    public function testNonDiagonalMatrixReturnsFalse()
    {
        $testBad = array(array(0,0,0),array(0,1,0),array(0,0,1));
        $mA = new Matrix($testBad);
        $this->assertFalse($this->object->is($mA));
    }
}
