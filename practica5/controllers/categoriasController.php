<?php

class categoriasController extends AppController
{
    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $categorias = $this->loadModel("categorias");
        $this->_view->categorias = $categorias->listarCategorias();

        $this->_view->titulo = "Listado de categorias";
        $this->_view->renderizar("index");
    }

    public function agregar(){
        if ($_POST){
            $categorias = $this->loadModel("categorias");
            if ($categorias->guardar($_POST)){
                $this->_messages->success('Categoría guardada correctamente', $this->redirect(array("controller"=>"categorias"))
                );
            }
        }

        $this->_view->titulo = "Agregar categoria";
        $this->_view->renderizar("agregar");
    }

    public function editar($id=null){
        if ($_POST){
            $categorias = $this->loadModel("categorias");

            if ($categorias->actualizar($_POST)){
                $this->_messages->success('Datos guardados correctamente', $this->redirect(array("controller"=>"categorias")));
            }else{
                $this->_view->flashMessage = "Error al guardar los datos...";
                $url = $this->redirect(array("controller"=>"categorias", "action"=>"editar/".$id));
                header("LOCATION:".$url);
            }
        }
        $categorias = $this->loadModel("categorias");
        $this->_view->categorias = $categorias->buscarPorId($id);

        $this->_view->titulo = "Editar categoria";
        $this->_view->renderizar("editar");
    }

    public function eliminar($id){
        $categorias = $this->loadModel("categorias");
        $registro = $categorias->buscarPorId($id);

        if (!empty($registro)){
            $categorias->eliminarPorId($id);
            $this->_messages->success('Categoria eliminada correctamente', $this->redirect(array("controller"=>"categorias")));
        }
    }
}
