<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Validator;
use DB;
use Log;

class CustomerController extends Controller
{

    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = $this->customer->all();

        return response()->json(['data', $customers], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(), $this->customer->rules());

        if ($validator->fails()) {
             return  $validator->messages()->first();
        }

        $dataForm =  $request->all();

        DB::beginTransaction();
        try
        {
            $this->customer->create($dataForm);
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $customer = $this->customer->where('id', $id)->first();
        if ($customer) {
            return response()->json($customer);
        } else {
            return response()->json(['data' => 'customer not found']);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = $this->customer->where('id', $id)->first();
        if ($customer) {
            return response()->json($customer);
        } else {
            return response()->json(['data' => 'customer not found']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $rules = $this->customer->rules();
        Log::info('rules');
        Log::info($rules);

       $validator = Validator::make( $request->all(),[
  'name' => 'required|string|max:50',
  'email' => 'sometimes|required|unique:customers,email,'.$id,
  'telephone' => 'required',
  'address' => 'required',
  'neighborhood' => 'required',
  'cep' => 'required',
       ] );


       if ($validator->fails()) {
        return  $validator->messages()->first();
   }


        $customer = $this->customer->findOrFail($id);


        Log::info('id');
        Log::info($id);

        Log::info('id antes');
        Log::info($customer);


        DB::beginTransaction();
        try
        {
            $this->customer->update([
              'name' => $request->name,
              'email' => $request->email,
              'telephone' => $request->telephone,
              'date_birth' => $request->date_birth,
              'address' => $request->date_birth,
              'complement' => $request->date_birth,
              'neighborhood' => $request->date_birth,
              'cep' => $request->date_birth,
            ]);
            DB::commit();

        Log::info('id depois');
        Log::info($customer);
            return  response()->json(['code'=>200,'message'=>'mensagem_sucesso']);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return $ex->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = $this->customer->findOrFail($id);

        DB::beginTransaction();
        try
        {
            $customer->delete();
            DB::commit();
            return  response()->json(['code'=>200,'message'=>'mensagem_sucesso']);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            return $ex->getMessage();
        }
    }
}
