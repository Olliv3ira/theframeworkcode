<?php

namespace app\helpers;

use core\Error;
use core\interfaces\Form;

class FormGenerator extends FieldValidator implements Form
{
    public function create(Form $form) 
    {
        
    }
        
    public function validate(Array $params) 
    {
        foreach ($params['dados'] as $keyd => $dado) { 
            
            foreach ($params['values'] as $keyv => $value) {
                
                if(("{$keyd}" === "{$keyv}") && parent::isValid($dado,$value['option'],$value['value'])) {
                    
                    Error::setError(array(
                        'number' => isset($value['error']['number'])?$value['error']['number']:'',
                        'message' => 'Erro: '.isset($value['error']['message'])?$value['error']['message']:''
                    ));
                    
                }
                
            }
                     
        }
        
    }
    
}