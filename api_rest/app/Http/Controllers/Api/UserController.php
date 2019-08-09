<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;   
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    private $user;
    
    public function __construct(User $user) {
        
        $this->user = $user;
        
    }

    public function index()
    {
        try {
            $data = $this->user->orderBy('updated_at', 'desc')->paginate(3);
            
            return response()->json($data, 200);
            
        } catch (Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], $e->getCode());
        }  
    }
    
    public function show($id)
    {
        try {
            $user = $this->user->find($id);
            
            if(!$user) return response()->json(['mensagem' => "Registro não encontrado!"], 404); 
            
            $data = ['data' => $user];

            return response()->json($data, 200);
            
        } catch (Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], $e->getCode());
        } 
    }
    
    public function save(Request $request)
    {
        try {            
            $new = $this->user->create([
                'email' => $request->email, 
                'name'  => $request->name,
                'password' => bcrypt($request->password),
                'address' => $request->address,
                'number' => $request->number,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
            ]);
                        
            return response()->json(['data' => ['mensagem' => 'Operação realizada com sucesso!', 'id' => $new->id]], 201);
            
        } catch (Exception $e) {
            return response()->json(['data' =>['mensagem' => $e->getMessage()]], $e->getCode());
        } 
    }
    
    public function update(Request $request, $id)
    {
        try {
            $user = $this->user->find($id);
            
            if(!$user) return response()->json(['mensagem' => "Registro não encontrado!"], 404); 
            
            $dataUser = $this->validateData($request);
            
            $user->update($dataUser);
            
            return response()->json(['mensagem' => 'Operação realizada com sucesso!'], 201);
            
        } catch (Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], $e->getCode());
        } 
    }
    
    public function dalete($id)
    {
        try {
            $user = $this->user->find($id);
            
            if(!$user) return response()->json(['mensagem' => "Registro não encontrado!"], 404); 
            
            $user->delete();
            
            return response()->json(['mensagem' => 'Operação realizada com sucesso!'], 201);
            
        } catch (Exception $e) {
            return response()->json(['mensagem' => $e->getMessage()], $e->getCode());
        } 
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['mensagem' => 'Credenciais invalidas!'], 400);
            }
            
        } catch (JWTException $e) {
            return response()->json(['mensagem' => 'Não foi possível criar o tokens!'], 500);
        }
        
        return response()->json(compact('token'), 200);
    }
    
    public function logout( Request $request ) {

        $token = $request->header( 'Authorization' );

        JWTAuth::parseToken()->invalidate( $token );

        return response()->json(['mensagem' => 'Desconectado!'], 200);

    }
    
    public function validateData($data){
        $dataUser = array();

        if($data->email) 
            $dataUser['email'] = $data->email;            
        if($data->name) 
            $dataUser['name']  = $data->name;
        if($data->password) 
            $dataUser['password'] = bcrypt($data->password);
        if($data->address) 
            $dataUser['address'] = $data->address;
        if($data->number) 
            $dataUser['number'] = $data->number;
        if($data->city) 
            $dataUser['city'] = $data->city;
        if($data->zip_code) 
            $dataUser['zip_code'] = $data->zip_code;
        
        return $dataUser;
    }
    
}
