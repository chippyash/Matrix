<?php
namespace Chippyash\Test\Matrix\Exceptions;
use Chippyash\Matrix\Exceptions;

/**
 * Unit test for alll Exception Classes
 */
class ExceptionsTest extends \PHPUnit_Framework_TestCase
{

    protected $exceptions = array();

    public function setUp()
    {
        $this->exceptions = array(
            'Matrix' => new Exceptions\MatrixException('foo'),
            'FormatterNotSet' => new Exceptions\FormatterNotSetException('foo'),
            'NotAnAttributeInterface' => new Exceptions\NotAnAttributeInterfaceException('foo'),
            'NotCompleteMatrix' => new Exceptions\NotCompleteMatrixException(2),
            'Vector' => new Exceptions\VectorException('foo'),
            'VerticeNotFound' => new Exceptions\VerticeNotFoundException(2,2),
            'VerticeOutOfBounds' => new Exceptions\VerticeOutOfBoundsException('foo', 2),
            'Transformation' => new Exceptions\TransformationException('foo')
        );
    }

    /**
     *
     * @param \Exception $ex
     */
    public function testExceptionsDerivedFromMatrixException()
    {
        foreach ($this->exceptions as $ex) {
            $this->assertInstanceOf('Chippyash\Matrix\Exceptions\MatrixException', $ex);
        }
    }

    public function testMatrixExceptionDerivedFromException()
    {
        $e = new Exceptions\MatrixException('foo');
        $this->assertInstanceOf('Exception', $e);
    }
}
