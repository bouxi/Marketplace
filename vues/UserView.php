<?php
class UserView {
    protected $controller;

    public function __construct($controller) {
        $this->controller = $controller;
    }

    public function createUser($data) {
        return $this->controller->createUser($data);
    }
}
