<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\BeautyLogBundle\Model;

class Meter implements MeterInterface {

    private $data = array();
    private $priority = array();
    private $countedData = array();

    public function handle(Array $collector){

        $this->data = $collector;

        if(empty($this->data)){
            return array();
        }

        $this->heapUp();
        $this->map();

        return $this;
    }

    public function getCountedData(){
        return $this->countedData;
    }

    public function heapUp(){

        foreach( $this->data as $item){
            $this->priority[$item["priority"]][] = $item['priorityName'] ;
        }

        return $this;
    }

    public function map(){

        foreach(  $this->priority as $k => $item){
            $this->countedData[$k]['count'] = count($item);
            $this->countedData[$k]['priorityName'] = $item[0];
        }

        return $this;
    }
}