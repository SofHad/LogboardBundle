<?php
/*
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
 * Symfony logs handler
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class FileStorageParameters implements ParametersHandlerInterface
{
    protected $filesystem;
    protected $kernelRootDir;

    /**
     * Construct
     *
     * @param integer                     $dataCount             The count of data
     * @param string                      $panel                 The panel
     *
     * @return void
     */
    public function __construct($filesystem, $kernelRootDir)
    {
        $this->filesystem = $filesystem;
        $this->kernelRootDir = $kernelRootDir;
    }

   /**
     * {@inheritdoc}
     *
     */
    public function getParameters(Profile $profile=null)
    {
        return array(
            'filesystem' => $this->filesystem ,
            'kernel_root_dir' => $this->kernelRootDir
        );
    }
}
