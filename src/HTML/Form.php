<?php

namespace App\HTML;


class Form
{
    private $data;
    private array $errors;

    /**
     * @param $data
     * @param array $errors
     */
    public function __construct($data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function input(string $key, string $label): string
    {
        $value = $this->getValue($key);

        return <<<HTML
    <div class="form-group">
        <label for="field{$key}">{$label}</label>
            <input type="text" id="fiel{$key}" class="{$this->getInputClass($key)}" name="{$key}" value="{$value}">
            {$this->getErrorFeedback($key)}
       
    </div>
    HTML;
    }

    public function textarea(string $key, string $label): string
    {
        $value = $this->getValue($key);

        return <<<HTML
    <div class="form-group">
        <label for="field{$key}">{$label}</label>
            <textarea id="fiel{$key}" class="{$this->getInputClass($key)}" name="{$key}">{$value}</textarea>
            {$this->getErrorFeedback($key)}
       
    </div>
    HTML;
    }

    private function getValue (string $key): ?string
    {
        if (is_array($this->data)){
            return $this->data[$key] ?? null;
        }
        $method = 'get' . str_replace(' ','', ucwords(str_replace('_',' ', $key)));
        $value = $this->data->$method();
        if($value instanceof \DateTimeInterface )
        {
            return $value->format('Y-m-d H:i:s');
        }
        return $value;
    }

    private function getInputClass(string $key): string
    {
        $inputClass = 'form-control';
        if(isset($this->errors[$key])){
            $inputClass .='is-invalid';
        }
        return $inputClass;
    }
    private function getErrorFeedback(string $key): string
    {
        $invalidFeedback = '';
        if(isset($this->errors[$key])){
            return '<div class="invalid-feedback">' .implode('<br>', $this->errors[$key]).'</div>';
        }
        return '';
    }
}