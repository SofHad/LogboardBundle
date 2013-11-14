<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Profiler;

/**
 * Counter
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class Counter implements CounterInterface
{

    private $data = array();
    private $countedData = array();

    /**
     * {@inheritdoc}
     *
     */
    public function handle(Array $collector)
    {
        $this->data = $collector;

        if (empty($this->data)) {
            return array();
        }

        $this->heapUp();

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function heapUp()
    {
        foreach ($this->data as $item) {
            if (isset($this->countedData[$item["key"]])) {
                $this->countedData[$item["key"]]['count']++;
            } else {
                $this->countedData[$item["key"]]['count'] = 1;
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getCountedData()
    {
        return $this->countedData;
    }

}