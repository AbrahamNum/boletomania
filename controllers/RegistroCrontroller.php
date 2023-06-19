<?php

namespace Controllers;

use Model\Cantante;
use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\EventosRegistros;
use Model\Hora;
use Model\Paquete;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class RegistroCrontroller
{

   public static function crear(Router $router){

        if(!is_auth()) {
            header('Location: /login');
        }

        // Verificar si el usuario ya esta registrado
        $registro = Registro::where('usuario_id', $_SESSION['id']);

        if(isset($registro) && ($registro->paquete_id === "3" || $registro->paquete_id === "2" )) {
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;
        }
        

        $router->render('registro/crear', [
            'titulo' => 'Finalizar Registro'
        ]);
    }
    public static function gratis(Router $router){

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_auth()) {
                header('Location: /login');
            }
        
            // Verificar si el usuario ya tiene un registro
            $registro = Registro::where('usuario_id', $_SESSION['id']);
        
            if(isset($registro) && $registro->paquete_id === "3") {
                header('Location: /boleto?id=' . urldecode($registro->token));
            }
        
            $token = substr( md5(uniqid( rand(), true )), 0, 8);
            
            //Crear registros
            $datos = [
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            ];
        
            $registro = new Registro($datos);
            $resultado = $registro->guardar();
        
            if($resultado) {
                header('Location: /boleto?id=' . urldecode($registro->token));
            }
        }
        }
        

        public static function boleto(Router $router) {

         
            // Llenar las tablas de referencia
            $registro->usuario = Usuario::find($registro->usuario_id);
            $registro->paquete = Paquete::find($registro->paquete_id);
    
            $router->render('registro/boleto', [
                'titulo' => 'Asistencia a un evento de Boletomania',
                'registro' => $registro
            ]);
        }

            public static function pagar(Router $router){


                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if(!is_auth()) {
                        header('Location: /login');
                    }
                
                    //Validar que Post no venga vacio 
                    if(empty($_POST)) {
                        echo json_encode([]);
                        return;
                    }
                
                    // Crear Registro
                    
                    $datos = $_POST;
                    $datos['token'] = substr( md5(uniqid( rand(), true )), 0, 8); 
                    $datos['usuario_id'] = $_SESSION['id'];
                
                    try {
                        $registro = new Registro($datos);
                        $resultado = $registro->guardar();
                        echo json_encode($resultado);
                        
                    } catch (\Throwable $th) {
                        echo json_encode([
                            'resultado' => 'error'
                        ]);
                    }
                }
            }


            public static function conciertos(Router $router){

                if(!is_auth()) {
                    header('Location: /login');
                }
                
                // Validar que tenga el paquete vip
                $usuario_id = $_SESSION['id'];
                $registro = Registro::where('usuario_id', $usuario_id);
                if(isset($registro) && $registro->paquete_id === "2") {
                    header('Location: /boleto?id=' . urlencode($registro->token));
                    return;
                }
                if($registro->paquete_id !== "1") {
                    header('Location: /');
                }
                
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
                
                //Manejando el registro mediante POST
                if($_SERVER['REQUEST_METHOD'] === 'POST') {

                    // Revisar que el usuario este autenticado
                    if(!is_auth()) {
                        header('Location: /login');
                    }
                    $eventos = explode(',', $_POST['eventos']);
                    
                    if(empty($eventos)) {
                        echo json_encode(['resultado' => false]);
                        return;
                    }
                    // Obtener el registro de usuario
                    $registro = Registro::where('usuario_id', $_SESSION['id']);
                    if(!isset($registro) || $registro->paquete_id !== "1") {
                        echo json_encode(['resultado' => false]);
                        return;
                    }
                    
                    $eventos_array = [];
                    // Validar la disponibilidad de los eventos seleccionados
                    foreach($eventos as $evento_id) {
                        $evento = Evento::find($evento_id);
                    // Comprobar que el evento exista
                    if(!isset($evento) || $evento->disponibles === "0") {
                        echo json_encode(['resultado' => false]);
                        return;
                    }
                    $eventos_array[] = $evento;
                     
                    }
                    foreach($eventos_array as $evento) {
                        $evento->disponibles -=1;
                        $evento->guardar();
                        // Almacenar el registro
                    $datos = [
                    'evento_id' =>  (int) $evento->id,
                    'registro_id' => (int)  $registro->id
                    ];
                    $registro_usuario = new EventosRegistros($datos);
                    $registro_usuario->guardar();
                    }
                    // Almacenar el registro
                    $registro->sincronizar();
                    $resultado = $registro->guardar();

                    if($resultado) {
                        echo json_encode([
                            'resultado' => $resultado, 
                            'token' => $registro->token
                        ]);
                    }else {
                        echo json_encode(['resultado' => false]);
                    }
        
                    
                    return;
                    



                    
                }

                
                $router->render('registro/conciertos', [
                    'titulo' => 'Elige un Concierto o un Festival',
                    'eventos' => $eventos_formateados,
                
                ]);
            }
}    


       
        
    
