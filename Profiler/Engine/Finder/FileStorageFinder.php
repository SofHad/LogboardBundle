<?php
/**
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Profiler\Engine\Finder;

use So\LogboardBundle\Profiler\Engine\Decompiler\DecompilerInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class FileStorageFinder
 *
 * @package So\LogboardBundle\Profiler\Engine\Finder
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class FileStorageFinder implements FinderInterface
{
    const PARSE_ERROR = "Parse error: unexpected value when trying to parse the log file";

    /**
     * Property accessor component
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $accessor;
    /**
     * The data
     * @var Array
     */
    protected $data = array();

    /**
     * The elements
     * @var Array
     */
    protected $elements = array();

    /**
     * The decompiler
     * @var Array
     */
    protected $decompiler;

    /**
     * The callback
     * @var string
     */
    protected $callback = null;

    /**
     * @param DecompilerInterface   $decompiler
     * @param string                $callback
     */
    public function __construct(DecompilerInterface $decompiler, $callback)
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->decompiler = $decompiler;
        $this->callback = $callback;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function find(Array $parameters)
    {
        if (
            null === $this->accessor->getValue($parameters, '[filesystem]')
            || null === $this->accessor->getValue($parameters, '[data]'))
        {
            throw new InvalidArgumentException();
        }

        $filesystem = $this->accessor->getValue($parameters, '[filesystem]');

        $filePath = $this->accessor->getValue($parameters, '[data]');

        if (!$filesystem instanceof Filesystem) {
            throw new InvalidArgumentException();
        }

        if (!$filesystem->exists($filePath)) {
            throw new FileNotFoundException($filePath);
        }

        $file = new \SplFileObject($filePath);

        foreach ($file as $line) {
            if (null !== $data = $this->decompiler->split($line)) {

                if ($this->hasCallback()) {
                    $data = $this->callbackHandler($data);
                }

                if (null !== $data) {
                    $this->data[] = $data;
                }
            }
        }

        return $this->data;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function callbackHandler($data)
    {
        return call_user_func_array($this->callback, array($data));
    }

    /**
     * {@inheritdoc}
     *
     */
    public function hasCallback()
    {
        return null === $this->callback ? false : true;
    }
}
