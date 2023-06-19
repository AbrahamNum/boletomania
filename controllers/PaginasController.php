<?php

namespace Controllers;

use Model\Cantante;
use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use MVC\Router;


class PaginasController {
    public static function index(Router $router) {
        $eventos = Evento::ordenar('hora_id', 'ASC');
        $eventos_formateados = [];
        foreach($eventos as $evento){

            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->cantante = Cantante::find($evento->cantante_id);

            if($evento->dia_id === "5" && $evento->categoria_id === "1"){
                $eventos_formateados['conciertos_v'][] = $evento;
            }
            if($evento->dia_id === "7" && $evento->categoria_id === "1"){
                $eventos_formateados['conciertos_s'][] = $evento;
            }
            if($evento->dia_id === "5" && $evento->categoria_id === "2"){
                $eventos_formateados['festivales_v'][] = $evento;
            }
            if($evento->dia_id === "7" && $evento->categoria_id === "2"){
                $eventos_formateados['festivales_s'][] = $evento;
            }
        }
         // Obtener el total de cada bloque
         $cantantes_total = Cantante::total();
         $conciertos_total = Evento::total('categoria_id', 1);
         $festivales_total = Evento::total('categoria_id', 2);
 
         // Obtener todos los ponentes
         $cantantes = Cantante::all();
        

        $router->render('paginas/index', [
            'titulo' => 'Inicio',
            'eventos' => $eventos_formateados,
            'cantantes_total' => $cantantes_total,
            'conciertos_total' => $conciertos_total,
            'festivales_total' => $festivales_total,
            'cantantes' => $cantantes
        ]);

    }
    public static function evento(Router $router) {

        

        $router->render('paginas/boletomania', [
            'titulo' => 'Sobre BoletoMania'
        ]);

    }
    public static function paquetes(Router $router) {

        

        $router->render('paginas/paquetes', [
            'titulo' => 'Paquetes BoletoMania'
        ]);

    }
    public static function conciertos(Router $router) {

        $eventos = Evento::ordenar('hora_id', 'ASC');
        $eventos_formateados = [];
        foreach($eventos as $evento){

            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->cantante = Cantante::find($evento->cantante_id);

            if($evento->dia_id === "5" && $evento->categoria_id === "1"){
                $eventos_formateados['conciertos_v'][] = $evento;
            }
            if($evento->dia_id === "7" && $evento->categoria_id === "1"){
                $eventos_formateados['conciertos_s'][] = $evento;
            }
            if($evento->dia_id === "5" && $evento->categoria_id === "2"){
                $eventos_formateados['festivales_v'][] = $evento;
            }
            if($evento->dia_id === "7" && $evento->categoria_id === "2"){
                $eventos_formateados['festivales_s'][] = $evento;
            }
        }
        
        //arreglo que se ira llenando con el foreach
       
           
        $router->render('paginas/conciertos', [
            'titulo' => 'Conciertos y festivales',
            'eventos' => $eventos_formateados
            
        ]);

    }
    public static function error(Router $router) {

        $router->render('paginas/error', [
            'titulo' => 'Página no encontrada'
        ]);
    }
}
