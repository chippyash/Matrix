<?php
namespace Chippyash\Test\Matrix\Transformation;
use Chippyash\Matrix\Transformation\Resize;
use Chippyash\Matrix\Matrix;

class ResizeTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected $testArray = array(
        array(1,2),
        array(1,2)
    );

    protected function setUp()
    {
        $this->object = new Resize();
    }

    /**
     * @expectedException \Chippyash\Matrix\Exceptions\MatrixException
     * @expectedExceptionMessage Second operand is not an array
     */
    public function testComputeThrowsExceptionIfSecondOperandNotAnArray()
    {
        $m = new Matrix($this->testArray);
        $this->object->transform($m, 'foo');
    }

    public function testResizingWithNullDimensionsWillAddOneColumnAndOneRow()
    {
        $m = new Matrix($this->testArray);
        $expected = array(
            array(1,2,null),
            array(1,2,null),
            array(null,null,null)
        );
        $this->assertEquals($expected, $this->object->transform($m, [])->toArray());
    }

    public function testResizingWithZeroDimensionsWillNotAddRowsOrColumns()
    {
        $m = new Matrix($this->testArray);
        $this->assertEquals($this->testArray, $this->object->transform($m, ['rows'=>0, 'cols'=>0])->toArray());
    }

    public function testYouCanSetTheDefaultValueWhenResizingUp()
    {
        $m = new Matrix($this->testArray);
        $expected = array(
            array(1,2,'foo'),
            array(1,2,'foo'),
            array('foo','foo','foo')
        );
        $this->assertEquals($expected, $this->object->transform($m, ['defaultValue' => 'foo'])->toArray());
    }

    public function testYouCanReduceAMatrix()
    {
        $m = new Matrix($this->testArray);
        $expected = array(
            array(1)
        );
        $this->assertEquals($expected, $this->object->transform($m, ['rows' => -1, 'cols' => -1])->toArray());
    }

    public function testYouCanAddRowsAndReduceColumnsAtTheSameTime()
    {
        $m = new Matrix($this->testArray);
        $expected = array(
            array(1, 2, 'foo')
        );
        $this->assertEquals(
            $expected,
            $this->object->transform(
                $m,
                ['rows' => -1, 'cols' => 1, 'defaultValue' =>'foo']
            )->toArray());
    }

    public function testYouCanAddColumnsAndReduceRowsAtTheSameTime()
    {
        $m = new Matrix($this->testArray);
        $expected = array(
            array(1),
            array(1),
            array('foo')
        );
        $this->assertEquals(
            $expected,
            $this->object->transform(
                $m,
                ['rows' => 1, 'cols' => -1, 'defaultValue' =>'foo']
            )->toArray());
    }
}
