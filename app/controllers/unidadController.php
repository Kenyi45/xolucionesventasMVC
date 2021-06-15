<?php

namespace App\Controllers;
use App\Daos\UnidadDAO;
use Libs\Controller;
use stdClass;

class UnidadController extends Controller
{
    public function __construct()
    {
        $this->loadDirectoryTemplate('unidad');
        $this->loadDAO('unidad');
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

        $obj->IdUnidad = isset($_POST['IdUnidad'])? intval($_POST['IdUnidad']):0;
        $obj->Nombre = isset($_POST['Nombre'])? $_POST['Nombre']:'';
        //$obj->estado = isset($_POST['estado'])? $_POST['estado']:false;

        if(isset($_POST['Estado'])){
            if($_POST['Estado'] == 'on'){
                $obj->Estado = true;
            }else{
                $obj->Estado = false;
            }
        }else{
            $obj->Estado = false;
        }

        if($obj->IdUnidad>0){
            $this->dao->update($obj);
        }else{
            $this->dao->create($obj);
        }

        header('Location:' . URL . 'unidad/index');
    }

    public function delete($param=null)
    {
        $id = isset($param[0]) ? $param[0] : 0;
        if($id > 0){
            $this->dao->delete($id);
        }
        header('Location:' . URL . 'unidad/index');
    }
}