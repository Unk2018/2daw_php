<?php
    interface Controller {
        public static function index();
        public static function create();
        public static function show();
        public static function edit();
        public static function save();
        public static function update();
        public static function delete();
    }
?>