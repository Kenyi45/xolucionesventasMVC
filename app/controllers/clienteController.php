<?php

namespace App\Controllers;
use App\Daos\ClienteDAO;
use Libs\Controller;
use stdClass;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->loadDirectoryTemplate('cliente');
        $this->loadDAO('cliente');
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

        $obj->IdCliente = isset($_POST['idcliente'])? intval($_POST['idcliente']):0;
        $obj->Nombres = isset($_POST['nombres'])? $_POST['nombres']:'';
        $obj->Apellidos = isset($_POST['apellidos'])? $_POST['apellidos']:'';
        $obj->Direccion = isset($_POST['direccion'])? $_POST['direccion']:'';
        $obj->Telf = isset($_POST['telf'])? $_POST['telf']:'';
        $obj->CreditoLimite = isset($_POST['creditolimite'])? doubleval($_POST['creditolimite']): 0.00 ;
        $obj->Ruc = isset($_POST['ruc'])? $_POST['ruc']:'';

        if(isset($_POST['estado'])){
            if($_POST['estado'] == 'on'){
                $obj->Estado = true;
            }else{
                $obj->Estado = false;
            }
        }else{
            $obj->Estado = false;
        }

        if($obj->IdCliente>0){
            $this->dao->update($obj);
        }else{
            $this->dao->create($obj);
        }

        header('Location:' . URL . 'cliente/index');
    }

    public function delete($param = null)
    {
        $id = isset($param[0]) ? $param[0] : 0;
        if($id > 0){
            $this->dao->delete($id);
        }
        header('Location:' . URL . 'cliente/index');
    }
}