<?php

namespace App\Controllers;
use App\Daos\CategoriaDAO;
use GUMP;
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
        $valid_data = $this->valida($_POST);
        $status = $valid_data['status'];
        $data = $valid_data['data'];
        $obj = new stdClass();

        if ($status === true) {
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
                $rpta = $this->dao->update($obj);
            }else{
                $rpta = $this->dao->create($obj);
            }

            if($rpta){
                $response=[
                    'success' => 1,
                    'message' => 'categoria guardada correctamente',
                    'redirection' => URL . 'categoria/index'
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
        header('Location:' . URL . 'categoria/index');
    }

    public function valida($datos)
    {
        $gump = new GUMP('es');
        $gump->validation_rules([
            'nombre' => 'required|max_len,50',
            'descripcion' => 'min_len,5|max_len,50'
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