<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Profiler\Engine;


/**
 * File storage engine
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class FileStorageEngine extends Engine
{
    /**
     * {@inheritdoc}
     *
     */
    public function heapUp()
    {
        return $this->profiles  = $this->data;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getName()
    {
        return 'file.storage';
    }
}
