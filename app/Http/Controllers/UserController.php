<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use DB;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->all();

        return response()->json(['data', $users], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->user->rules());

        if ($validator->fails()) {
             return  $validator->messages()->first();
        }

        $dataForm =  $request->all();

        DB::beginTransaction();
        try
        {
            $this->user->create([
                'name' => $dataForm['name'],
                'email' => $dataForm['email'],
                'password' => Hash::make($dataForm['password']),
            ]);
            DB::commit();
            return  response()->json(['code'=>200,'message'=>'mensagem_sucesso']);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return $ex->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user->where('id', $id)->first();
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['data' => 'user not found']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->where('id', $id)->first();
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['data' => 'user not found']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = $this->user->rules();
        $rules['email'] = 'unique:users,email,'.$id;
        $rules['password'] = '';

        $validator = Validator::make( $request->all(),$rules);

        if ($validator->fails()) {
            return  $validator->messages()->first();
        }
        $user = $this->user->where('id', $id)->first();

        $dataForm = $request->all();

        DB::beginTransaction();
        try
        {
            if ($user) {
                $user->update($dataForm);
                DB::commit();
                return  response()->json(['code'=>200,'message'=>'mensagem_sucesso']);
            } else {
                return response()->json(['data' => 'user not found']);
            }
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
             return response()->json(['data' => $ex->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->where('id', $id)->first();

        DB::beginTransaction();
        try
        {
            if ($user) {
                $user->delete();
                DB::commit();
                return  response()->json(['code'=>200,'message'=>'mensagem_sucesso']);
            } else {
                return response()->json(['data' => 'user not found']);
            }
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return response()->json(['data' => $ex->getMessage()], 422);
        }
    }
}
