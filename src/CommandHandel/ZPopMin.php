<?php

namespace EasySwoole\Redis\CommandHandel;

use EasySwoole\Redis\CommandConst;
use EasySwoole\Redis\Response;

class ZPopMin extends AbstractCommandHandel
{
    public $commandName = 'ZPopMin';
    
    public function handelCommandData(...$data)
    {
        $key = array_shift($data);
        $this->setClusterExecClientByKey($key);
        $count = array_shift($data);
        
        $command = [CommandConst::ZPOPMIN, $key];
        if (!is_null($count) && $count > 1) {
            $command[] = $count;
        }
        return $command;
    }
    
    
    public function handelRecv(Response $recv)
    {
        $data = $recv->getData();
        
        $result = [];
        foreach ($data as $k => $va) {
            if ($k % 2 == 1) {
                $result[$this->unSerialize($data[$k - 1])] = $this->unSerialize($va);
            }
        }
        
        return $result;
    }
}
