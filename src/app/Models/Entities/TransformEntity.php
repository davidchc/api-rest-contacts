<?php


namespace App\Models\Entities;


trait TransformEntity
{
    public function populateEntity(array $data = [])
    {
        foreach($data as $key => $value) {
            $method = $this->prepareMethodName($key);
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

    protected function prepareMethodName($name)
    {
        $nameMethod = ucwords(str_replace('_', ' ', $name));
        return sprintf("set%s", str_replace(' ', '', $nameMethod));
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}