<?php

namespace app\helpers;

use core\interfaces\Validate;

class FieldValidator implements Validate
{
    private $result;
    
    public function isValid($value1, $option, $value2)
    {
        switch ($option) {
            case '==':
                $this->result = ($value1 == $value2);
                break;
             case '!=':
                $this->result = ($value1 != $value2);
                break;
            case '===':
                $this->result = ($value1 === $value2);
                break;
            case '!==':
                $this->result = ($value1 !== $value2);
                break;
            case '>':
                $this->result = ($value1 > $value2);
                break;
            case '>=':
                $this->result = ($value1 >= $value2);
                break;
            case '<':
                $this->result = ($value1 < $value2);
                break;
            case '<=':
                $this->result = ($value1 <= $value2);
                break;            
        }
        
        return $this->result;
    }
    
    
}