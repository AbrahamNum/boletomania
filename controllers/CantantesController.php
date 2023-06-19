<?php

namespace Controllers;
use Classes\Paginacion;
use Model\Cantante;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class CantantesController
{

   public static function index(Router $router)
   {
      if(!is_admin()) {
         header('Location: /login');
     }
      $pagina_actual = $_GET['page'];
      $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

      if(!$pagina_actual || $pagina_actual < 1) {
         header('Location: /admin/cantantes?page=1');
      }

      $registros_por_pagina = 5;
      $total = Cantante::total();
      $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

      if($paginacion->total_paginas() < $pagina_actual) {
          header('Location: /admin/cantantes?page=1');
      }

      $cantantes = Cantante::paginar($registros_por_pagina, $paginacion->offset());

      if (!is_admin()) {
         header('Location: /login');
      }

      $router->render('admin/cantantes/index', [
         'titulo' => 'Cantantes',
         'cantantes' => $cantantes,
         'paginacion' => $paginacion->paginacion()
      ]);
   }
   public static function crear(Router $router)
   {
      if (!is_admin()) {
         header('Location: /login');
      }
      $alertas = [];
      $cantante = new Cantante();

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         //leer imagen
         if (!empty($_FILES['imagen']['tmp_name'])) {
            $carpeta_imagenes = '../public/img/cantantes';

            //crear la carpeta si no existe
            if (!is_dir($carpeta_imagenes)) {
               mkdir($carpeta_imagenes, 0755, true);
            }

            $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
            $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);
            //solo se almacena el nombre en la base de datos
            $nombre_imagen = md5(uniqid(rand(), true));

            $_POST['imagen'] = $nombre_imagen;
         }

         $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

         $cantante->sincronizar($_POST);

         //validar
         $alertas = $cantante->validar();

         //Guardar el registro
         if (empty($alertas)) {
            //Guardar las imagenes
            $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
            $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");

            //Guardar en la BD
            $resultado = $cantante->guardar();

            if ($resultado) {
               header('Location: /admin/cantantes');
            }
         }
      }
      $router->render('admin/cantantes/crear', [
         'titulo' => 'Registrar Cantantes',
         'alertas' => $alertas,
         'cantante' => $cantante,
         'redes' => json_decode($cantante->redes)
      ]);
   }
   public static function editar(Router $router)
   {
      if (!is_admin()) {
         header('Location: /login');
      }
      $alertas = [];
      //Validad ID del cantante
      $id = $_GET['id'];
      //Garantiza que el ID sea un numero entero
      $id = filter_var($id, FILTER_VALIDATE_INT);

      if (!$id) {
         header('Location: /admin/cantantes');
      }
      //Obteniene el ponente a editar
      $cantante = Cantante::find($id);

      if (!$cantante) {
         header('Location: /admin/cantantes');
      }
      //variable temporal
      $cantante->imagen_actual = $cantante->imagen;

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {

         if (!empty($_FILES['imagen']['tmp_name'])) {

            $carpeta_imagenes = '../public/img/cantantes';

            // Crear la carpeta si no existe
            if (!is_dir($carpeta_imagenes)) {
               mkdir($carpeta_imagenes, 0755, true);
            }

            $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
            $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);

            $nombre_imagen = md5(uniqid(rand(), true));

            $_POST['imagen'] = $nombre_imagen;
         } else {
            $_POST['imagen'] = $cantante->imagen_actual;
         }

         $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
         $cantante->sincronizar($_POST);

         $alertas = $cantante->validar();

         if (empty($alertas)) {
            if (isset($nombre_imagen)) {
               $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
               $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
            }
            $resultado = $cantante->guardar();
            if ($resultado) {
               header('Location: /admin/cantantes');
            }
         }
      }

      $router->render('admin/cantantes/editar', [
         'titulo' => 'Actualizar Cantante',
         'alertas' => $alertas,
         'cantante' => $cantante,
         'redes' => json_decode($cantante->redes)
      ]);
   }
   public static function eliminar()
   {
      if (!is_admin()) {
         header('Location: /login');
      }
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {

         $id = $_POST['id'];
         //instanciar al cantante
         $cantante = Cantante::find($id);
         if (!isset($cantante)) {
            header('Location: /admin/cantantes');
         }
         $resultado = $cantante->eliminar();
         if ($resultado) {
            header('Location: /admin/cantantes');
         }
      }
   }
}
