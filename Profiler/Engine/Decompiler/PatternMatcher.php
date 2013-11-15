<?php

/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Profiler\Engine\Decompiler;

use So\LogboardBundle\Exception\InvalidArgumentException;
use Symfony\Component\PropertyAccess\PropertyAccess;

class PatternMatcher implements DecompilerInterface
{

    protected $pattern;
    protected $key;
    protected $value;

    /**
     * Constructor
     *
     * @param string $pattern   The regex pattern
     * @param integer $key      The key
     * @param integer $value    The value
     *
     * @return void
     */
    public function __construct($pattern, $key = 1, $value = 2)
    {
        if (!is_string($pattern)) {
            throw new InvalidArgumentException(sprintf('Argument 1 passed to "%s" must be a string', __METHOD__));
        }

        if (!is_integer($key)) {
            throw new InvalidArgumentException(sprintf('Argument 2 passed to "%s" must be an integer', __METHOD__));
        }

        if (!is_integer($value)) {
            throw new InvalidArgumentException(sprintf('Argument 3 passed to "%s" must be an integer', __METHOD__));
        }

        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->pattern = $pattern;
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function split($input)
    {

        $output = array();

        if (empty($input)) {
            return;
        }

        preg_match($this->pattern, $input, $matches);

        if (null === $matches || !isset($matches[$this->key]) || !isset($matches[$this->value])) {
            return;
        }

        $output['key'] = $matches[$this->key];
        $output['value'] = str_replace("[]", null, $matches[0]);

        return $output;
    }
}
