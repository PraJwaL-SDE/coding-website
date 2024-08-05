<?php
class Problem {
    private $id;
    private $description;
    private $example;
    private $correctCode;
    private $testCases;
    private $prefixCode;
    private $postfixCode;
    private $emptyCode;

    // Constructor
    public function __construct($id, $description, $example, $correctCode, $testCases, $prefixCode, $postfixCode, $emptyCode) {
        $this->id = $id;
        $this->description = $description;
        $this->example = $example;
        $this->correctCode = $correctCode;
        $this->testCases = $testCases;
        $this->prefixCode = $prefixCode;
        $this->postfixCode = $postfixCode;
        $this->emptyCode = $emptyCode;
    }

    public function toJSON() {
        return json_encode(get_object_vars($this));
    }

    // Getter and setter for id
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter and setter for description
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    // Getter and setter for example
    public function getExample() {
        return $this->example;
    }

    public function setExample($example) {
        $this->example = $example;
    }

    // Getter and setter for correctCode
    public function getCorrectCode() {
        return $this->correctCode;
    }

    public function setCorrectCode($correctCode) {
        $this->correctCode = $correctCode;
    }

    // Getter and setter for testCases
    public function getTestCases() {
        return $this->testCases;
    }

    public function setTestCases($testCases) {
        $this->testCases = $testCases;
    }

    // Getter and setter for prefixCode
    public function getPrefixCode() {
        return $this->prefixCode;
    }

    public function setPrefixCode($prefixCode) {
        $this->prefixCode = $prefixCode;
    }

    // Getter and setter for postfixCode
    public function getPostfixCode() {
        return $this->postfixCode;
    }

    public function setPostfixCode($postfixCode) {
        $this->postfixCode = $postfixCode;
    }

    // Getter and setter for emptyCode
    public function getEmptyCode() {
        return $this->emptyCode;
    }

    public function setEmptyCode($emptyCode) {
        $this->emptyCode = $emptyCode;
    }
}




?>