<?php

namespace App\Controllers;
use GUMP;
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
        $valid_data = $this->valida($_POST);
        $status = $valid_data['status'];
        $data = $valid_data['data'];

        if($status == true){
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
                $rpta = $this->dao->update($obj);
            }else{
                $rpta = $this->dao->create($obj);
            }

            if($rpta){
                $response=[
                    'success' => 1,
                    'message' => 'Cliente guardado correctamente',
                    'redirection' => URL . 'cliente/index'
                ];
            }else{
                $response=[
                    'success' => 0,
                    'message' => 'Error al guardar los datos',
                    'redirection' => ''
                ];
            }
        }else{
            $response=[
                'success' => -1,
                'message' => $data,
                'redirection' => ''
            ];
        }

        echo json_encode($response);
    }

    public function delete($param = null)
    {
        $id = isset($param[0]) ? $param[0] : 0;
        if($id > 0){
            $this->dao->delete($id);
        }
        header('Location:' . URL . 'cliente/index');
    }

    public function valida($datos)
    {
        $gump = new GUMP('es');
        $gump->validation_rules([
            'nombres' => 'required|min_len,6|max_len,20',
            'apellidos' => 'required|min_len,4|max_len,50',
            'direccion' => 'min_len,5|max_len,100',
            'telf' => 'required|max_len,20',
            'creditolimite' => 'required|min_len,2|max_len,12',
            'ruc' => 'required|max_len,11'
        ]);

        $valid_data = $gump->run($datos);

        if ($gump->errors()) {
            $response = [
                'status' => false,
                'data' => $gump->get_errors_array()
            ];
        }else{
            $response = [
                'status' => true,
                'data' => $valid_data
            ];
        }

        return $response;
    }
}