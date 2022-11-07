<?php
    interface Controller {
        public function index();
        public function create();
        public function show();
        public function edit();
        public function save();
        public function update();
        public function delete();
    }
?>