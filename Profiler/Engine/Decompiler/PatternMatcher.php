<?php

/**
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

/**
 * Class PatternMatcher
 *
 * @package So\LogboardBundle\Profiler\Engine\Decompiler
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class PatternMatcher implements DecompilerInterface
{
    protected $pattern;
    protected $key;

    /**
     * @param string  $pattern The pattern
     * @param int $key         The key
     *
     * @throws InvalidArgumentException  If errors in arguments
     */
    public function __construct($pattern, $key = 1)
    {
        if (!is_string($pattern)) {
            throw new InvalidArgumentException(sprintf(
                'Argument 1 passed to "%s" must be a string', __METHOD__)
            );
        }

        if (!is_integer($key)) {
            throw new InvalidArgumentException(
                sprintf('Argument 2 passed to "%s" must be an integer', __METHOD__)
            );
        }

        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->pattern = $pattern;
        $this->key = $key;
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

        if (null === $matches || !isset($matches[$this->key])) {
            return;
        }

        $output['key'] = $matches[$this->key];
        $output['value'] = str_replace("[]", null, $matches[0]);

        return $output;
    }
}
