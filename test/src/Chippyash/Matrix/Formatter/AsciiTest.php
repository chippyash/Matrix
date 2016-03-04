<?php
namespace Chippyash\Test\Matrix\Formatter;
use Chippyash\Matrix\Formatter\Ascii;
use Chippyash\Matrix\Matrix;

/**
 * Unit test for Matrix Ascii formatter
 */
class AsciiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Ascii
     */
    protected $object;

    public function setUp()
    {
        $this->object = new Ascii();
    }

    public function testConstructGivesFormatterInterface()
    {
        $this->assertInstanceOf('Chippyash\Matrix\Formatter\Ascii', $this->object);
        $this->assertInstanceOf('Chippyash\Matrix\Interfaces\FormatterInterface', $this->object);
    }

    public function testFormatEmptyMatrixReturnsEmptyBox()
    {
        $mA = new Matrix([]);
        $test = <<<EOF
++
++

EOF;
        $this->assertEquals($test, $this->object->format($mA));
    }

    public function testFormatSingleItemMatrixReturnsSingleItemBox()
    {
        $mA = new Matrix([1]);
        $test = <<<EOF
+--+
| 1|
+--+

EOF;
        $this->assertEquals($test, $this->object->format($mA));
    }

    public function testFormatBooleanMatrixReturnsMatrixBox()
    {
        $mA = new Matrix(array(array(true, false)));
        $test = <<<EOF
+----+
| 1 0|
+----+

EOF;
        $this->assertEquals($test, $this->object->format($mA));
    }

    public function testFormatSingleRowMatrixReturnsSingleRowBox()
    {
        $mA = new Matrix(array(array(1,2,10)));
        $test = <<<EOF
+---------+
|  1  2 10|
+---------+

EOF;
        $this->assertEquals($test, $this->object->format($mA));
    }

    public function testFormatSingleColumnMatrixReturnsSingleColumnBox()
    {
        $mA = new Matrix(array(array(100), array(200), array(300)));
        $test = <<<EOF
+----+
| 100|
| 200|
| 300|
+----+

EOF;
        $this->assertEquals($test, $this->object->format($mA));
    }

    public function testFormatMultiRowMatrixReturnsMultiRowBox()
    {
        $mA = new Matrix(array(array(1,2,10), array(14, 213, 1), array(54, 1, 100)));
        $test = <<<EOF
+------------+
|   1   2  10|
|  14 213   1|
|  54   1 100|
+------------+

EOF;
        $this->assertEquals($test, $this->object->format($mA));
    }

    public function testBooleansGetConverted()
    {
        $mA = new Matrix(array(array(true,false,true)));
        $test = <<<EOF
+------+
| 1 0 1|
+------+

EOF;
        $this->assertEquals($test, $this->object->format($mA));
    }
}
