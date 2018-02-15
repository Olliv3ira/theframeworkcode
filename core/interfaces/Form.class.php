<?php

namespace core\interfaces;

interface Form {
        
    public function create(Form $form);
    public function validate(Array $params);
    
}