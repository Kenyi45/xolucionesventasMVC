<?php
namespace App\Daos;

use App\Models\ClienteModel;
use Illuminate\Database\Eloquent\Model;
use Libs\Dao;
use stdClass;

class ClienteDAO extends Dao
{
    public function __construct()
    {
        $this->loadEloquent();
    }

    public function getAll(bool $estado)
    {
        $result = ClienteModel::where('Estado', $estado)->orderBy('IdCliente', 'DESC')->get();
        return $result;
    }

    public function get(int $id)
    {
        $model = ClienteModel::find($id);

        if (is_null($model)) 
        {
            $model=new stdClass();
            $model->IdCliente = 0;
            $model->Nombres = '';
            $model->Apellidos = '';
            $model->Direccion = '';
            $model->Telf = '';
            $model->CreditoLimite = 0.00;
            $model->Ruc = '';
            $model->Estado = 0;
        }
        return $model;
    }

    public function create($obj){
        
        $model = new ClienteModel();
        $model->IdCliente = $obj->IdCliente;
        $model->Nombres = $obj->Nombres;
        $model->Apellidos = $obj->Apellidos;
        $model->Direccion = $obj->Direccion;
        $model->Telf = $obj->Telf;
        $model->CreditoLimite = $obj->CreditoLimite;
        $model->Ruc = $obj->Ruc;
        $model->Estado = $obj->Estado;
        return $model->save();
    }

    public function update($obj){
        $model = ClienteModel::find($obj->IdCliente);
        $model->IdCliente = $obj->IdCliente;
        $model->Nombres = $obj->Nombres;
        $model->Apellidos = $obj->Apellidos;
        $model->Direccion = $obj->Direccion;
        $model->Telf = $obj->Telf;
        $model->CreditoLimite = $obj->CreditoLimite;
        $model->Ruc = $obj->Ruc;
        $model->Estado = $obj->Estado;
        return $model->save();
    }

    public function delete(int $id){
        
        $model = ClienteModel::find($id);
        return $model->delete();
    }

    public function baja(int $id){
        
        $sql = "UPDATE clientes SET estado=false WHERE idcliente=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(1, $id, \PDO::PARAM_INT);
        return $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
    }
}