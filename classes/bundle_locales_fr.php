<?php

namespace adapt\locales\fr{
    
    /* Prevent Direct Access */
    defined('ADAPT_STARTED') or die;
    
    class bundle_locales_fr extends \adapt\bundle{
        
        public function __construct($data){
            parent::__construct('locales_fr', $data);
        }
        
        public function boot(){
            if (parent::boot()){
                
                /* Add the validators */
                $this->sanitize->add_validator('fr_phone', "^(\+33|0)[1-9]([0-9]{2,2}){4,4}$");
                $this->sanitize->add_validator('fr_phone_mobile', "^(\+33|0)(6|7)([0-9]{2,2}){4,4}$");
                $this->sanitize->add_validator('fr_phone_landline', "^(\+33|0)([1-5]|8|9)([0-9]{2,2}){4,4}$");
                
                $this->sanitize->add_validator('fr_postcode', "^[0-9]{5,5}$");
                
                /* Add formatters */
                $this->sanitize->add_format('fr_phone', function($value){
                    if (preg_match("/0\d{9,9}/", $value)){
                        //(011x) xxx xxxx
                        return substr($value, 0, 2) . ' ' . substr($value, 2, 2) . ' ' . substr($value, 4, 2) . ' ' . substr($value, 6, 2) . ' ' . substr($value, 8, 2);
                    }
                    
                    return $value;
                    
                }, "function(value){
                    if (value.match(new RegExp('^0[0-9]{9,9}\$'))){
                        return value.substr(0,2) + ' ' + value.substr(2,2) + ' ' + value.substr(4,2) + ' ' + value.substr(6,2) + ' ' + value.substr(8,2);
                    }
                    return value;
                }");

                
                $this->sanitize->add_format('fr_date',
                    function($value){
                        if ($value === null  || $value == '') return null;
                        return \adapt\date::convert_date('Y-m-d', 'd-m-Y', $value);
                    },
                    "function(value){
                        return adapt.date.convert_date('Y-m-d', 'd-m-Y', value);
                    }"
                );
                
                $this->sanitize->add_format('fr_time',
                    function($value){
                        if ($value === null  || $value == '') return null;
                        return \adapt\date::convert_date('H:i:s', 'H:i', $value);
                    },
                    "function(value){
                        return adapt.date.convert_date('H:i:s', 'H:i', value);
                    }"
                );
                
                $this->sanitize->add_format('fr_datetime',
                    function($value){
                        if ($value === null  || $value == '') return null;
                        return \adapt\date::convert_date('Y-m-d H:i:s', 'd-m-Y H:i', $value);
                    },
                    "function(value){
                        return adapt.date.convert_date('Y-m-d H:i:s', 'd-m-Y H:i', value);
                    }"
                );
                
                
                /* Add unformatters */
                $this->sanitize->add_unformat('fr_date',
                    function($value){
                        if ($value === null  || $value == '') return null;
                        $value = preg_replace("/[^0-9]/", '', $value);
                        return \adapt\date::convert_date('dmY', 'Y-m-d', $value);
                    },
                    "function(value){
                        value = value.replace(/[^0-9]/g, '');
                        return adapt.date.convert_date('dmY', 'Y-m-d', value);
                    }"
                );
                
                $this->sanitize->add_unformat('fr_time',
                    function($value){
                        if ($value === null  || $value == '') return null;
                        $value = preg_replace("/[^0-9]/", '', $value);
                        return \adapt\date::convert_date('Hi', 'H:i:s', $value);
                    },
                    "function(value){
                        value = value.replace(/[^0-9]/g, '');
                        return adapt.date.convert_date('Hi', 'H:i:s', value);
                    }"
                );
                
                $this->sanitize->add_unformat('fr_datetime',
                    function($value){
                        if ($value === null  || $value == '') return null;
                        $value = preg_replace("/[^0-9]/", '', $value);
                        return \adapt\date::convert_date('dmYHi', 'Y-m-d H:i:s', $value);
                    },
                    "function(value){
                        value = value.replace(/[^0-9]/g, '');
                        return adapt.date.convert_date('dmYHi', 'Y-m-d H:i:s', value);
                    }"
                );

                
                return true;
            }
            
            return false;
        }
        
    }
    
    
}

?>