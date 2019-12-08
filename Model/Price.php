<?php

class Price implements JsonSerializable {

    private $value;
    private $currency;
    private $formated;

    public function __construct($value, $currency, $formated) {
        $this->setValue($value);
        $this->setCurrency($currency);
        $this->setFormated($formated);
    }

    public function setValue($value) { $this->value = $value; }
    public function setCurrency($value) { $this->currency = $value; }
    public function setFormated($value) { $this->formated = $value; }
    public function getValue() { return $this->value; }
    public function getCurrency() { return $this->currency; }
    public function getFormated() { return $this->formated; }

    public function jsonSerialize() {
        return [
            "currency" => $this->currency,
            "price" => $this->price,
            "formated" => $this->formated,
        ];
    }
}