<?php
/*
 * Matrix library
 *
 * @author Ashley Kitson <akitson@zf4.biz>
 * @copyright Ashley Kitson, UK, 2014
 * @licence GPL V3 or later : http://www.gnu.org/licenses/gpl.html
 */
namespace Chippyash\Matrix\Interfaces;

/**
 *
 * Class providing a magic invokable interface.  this is primarily used
 * to differentiate between a callable (or lambda) function and a class that
 * that is invokable.  Both respond true to is_callable making it difficult
 * to differentiate the two.
 *
 * @codeCoverageIgnore
 * @see https://wiki.php.net/rfc/invokable
 * @see AbstractDecomposition::product for an example
 */
interface InvokableInterface
{
    /**
     * proxy to some other method
     *
     * @param mixed
     * @codeCoverageIgnore
     */
    public function __invoke();
}
