<?php

class Price {

    private $value;
    private $currency;

    public function __construct($value, $currency) {
        $this->setValue($value);
        $this->setCurrency($currency);
    }

    public function setValue($value) { $this->value = $value; }
    public function setCurrency($value) { $this->currency = $value; }
    public function getValue() { return $this->value; }
    public function getCurrency() { return $this->currency; }

    public function __toString() {
        return strVal($this->value)." ".$this->$currency;
    }
}