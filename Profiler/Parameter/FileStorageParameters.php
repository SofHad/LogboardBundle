<?php
/**
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Profiler\Parameter;

use Symfony\Component\HttpKernel\Profiler\Profile;

/**
 * File storage parameters
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class FileStorageParameters implements ParametersHandlerInterface
{
    protected $filesystem;
    protected $file;

    /**
     * Construct
     *
     * @param integer $dataCount The count of data
     * @param string $file The file path
     *
     * @return void
     */
    public function __construct($filesystem, $file)
    {
        $this->filesystem = $filesystem;
        $this->file = $file;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getParameters(Profile $profile = null)
    {
        return array(
            'filesystem' => $this->filesystem,
            'data' => $this->file
        );
    }
}
