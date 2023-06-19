<?php

namespace Controllers;
use Model\Cantante;

class APICantantes {

    public static function index() {
        $cantantes = Cantante::all();
        echo json_encode($cantantes);
    }

    public static function cantante() {
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id || $id < 1) {
            echo json_encode([]);
            return;
        }

        $cantante = Cantante::find($id);
        echo json_encode($cantante, JSON_UNESCAPED_SLASHES);
    }
}