<?php

class tareasController extends AppController
{

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$tareas = $this->loadmodel("tarea");
		$this->_view->tareas = $tareas->getTareas();
		
		$this->_view->titulo = "Listado de tareas";
		$this->_view->renderizar("index");
	}

	public function agregar(){
	    if ($_POST){
	        $tareas = $this->loadModel("tarea");
	        if ($tareas->guardar($_POST)){
	            $this->_messages->success('Tarea guardada correctamente', $this->redirect(array("controller"=>"tareas"))
                );
            }
        }

        $categorias = $this->loadModel("categorias");
	    $this->_view->categorias = $categorias->listarCategorias();

        $this->_view->titulo = "Agregar de tareas";
        $this->_view->renderizar("agregar");
    }

    public function editar($id=null){
	    if ($_POST){
            $tarea = $this->loadModel("tarea");

            if ($tarea->actualizar($_POST)){
                //$this->_view->flashMessage = "Datos guardados correctamente...";
                $this->_messages->success('Datos guardados correctamente', $this->redirect(array("controller"=>"tareas")));
                //$this->redirect(array("controller"=>"tareas"));
            }else{
                $this->_view->flashMessage = "Error al guardar los datos...";
                $url = $this->redirect(array("controller"=>"tareas", "action"=>"editar/".$id));
                header("LOCATION:".$url);
            }
        }
        $tarea = $this->loadModel("tarea");
        $this->_view->tarea = $tarea->buscarPorId($id);

        $categorias = $this->loadModel("categorias");
        $this->_view->categorias = $categorias->listarCategorias();

        $this->_view->titulo = "Editar tarea";
        $this->_view->renderizar("editar");
    }

    public function eliminar($id){
        $tarea = $this->loadModel("tarea");
        $registro = $tarea->buscarPorId($id);

        if (!empty($registro)){
            $tarea->eliminarPorId($id);
            $this->_messages->success('Tarea eliminada correctamente', $this->redirect(array("controller"=>"tareas")));
            //$url = $this->redirect(array("controller"=>"tareas"));
            //header("LOCATION:".$url);
        }
    }

    public function cambiarEstado($id, $status){
        $tarea = $this->loadModel("tarea");
        if ($status=="off"){
            $estado = 0;
        }elseif ($status=="on"){
            $estado = 1;
        }
        $tarea->status($id, $estado);
        $url = $this->redirect(array("controller"=>"tareas"));
        header("LOCATION:".$url);
    }
}