<?php
/**
 * Created by PhpStorm.
 * User: emmanuelboyer
 * Date: 2019-02-13
 * Time: 2:47 AM
 */

class Validation
{
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    public function __construct()
    {
        $this->_db =Database::getInstance();
    }

    public function check($source, $items = array())
    {
        foreach ($items as $item => $rules)
        {
            foreach ($rules as $rule => $ruleValue)
            {
                $value = trim($source[$item]);
                $item = escape($item);
                if ($rule === 'required' && empty($value))
                {
                    $this->addError("{$item} is required");
                }
                else if (!empty($value))
                {
                    switch ($rule)
                    {
                        case 'min' :
                            if (strlen($value) < $ruleValue)
                            {
                                $this->addError("{$item} doit être un minimum de  {$ruleValue} caratères");
                            }
                            break;
                        case 'max' :
                            if (strlen($value) > $ruleValue)
                            {
                                $this->addError("{$item} doit être un maximum de  {$ruleValue} caratères");
                            }
                            break;
                        case 'matches' :
                                if ($value != $source[$ruleValue])
                                {
                                    $this->addError("{$ruleValue} doit être égale à {$item}");
                                }
                            break;
                        case 'unique' :
                                //$check = $this->_db->query();
                                $check = $this->_db->get($ruleValue, array($item, '=', $value) );
                                if ($check->count())
                                {
                                    $this->addError("{$item} est déjà utilisé.");
                                }
                            break;
                    }
                }
            }
            if (empty($this->_errors))
            {
                $this->_passed = true;
            }
            return $this;
        }
    }

    private function addError($error)
    {
        $this->_errors[] = $error;
    }
    public function errors()
    {
        return $this->_errors;
    }
    public function passed()
    {
        return $this->_passed;
    }
}