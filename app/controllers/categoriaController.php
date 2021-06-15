<?php

namespace App\Controllers;
use App\Daos\CategoriaDAO;
use Libs\Controller;
use stdClass;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->loadDirectoryTemplate('categoria');
        $this->loadDAO('categoria');
    }

    public function index()
    {
        $data = $this->dao->getAll(true);
        echo $this->template->render('index', ['data' => $data]);
    }

    public function detail($param=null)
    {
        $id = isset($param[0]) ? $param[0] : 0;
        $data = $this->dao->get($id);
        // myEcho($data);
        echo $this->template->render('detail',['data'=>$data]);
    }

    public function save()
    {
        $obj = new stdClass();

        $obj->IdCateg = isset($_POST['idcateg'])? intval($_POST['idcateg']):0;
        $obj->Nombre = isset($_POST['nombre'])? $_POST['nombre']:'';
        $obj->Descripcion = isset($_POST['descripcion'])? $_POST['descripcion']:'';
        //$obj->estado = isset($_POST['estado'])? $_POST['estado']:false;

        if(isset($_POST['estado'])){
            if($_POST['estado'] == 'on'){
                $obj->Estado = true;
            }else{
                $obj->Estado = false;
            }
        }else{
            $obj->Estado = false;
        }

        if($obj->IdCateg>0){
            $this->dao->update($obj);
        }else{
            $this->dao->create($obj);
        }

        header('Location:' . URL . 'categoria/index');
    }

    public function delete($param = null)
    {
        $id = isset($param[0]) ? $param[0] : 0;
        if($id > 0){
            $this->dao->delete($id);
        }
        header('Location:' . URL . 'categoria/index');
    }
}