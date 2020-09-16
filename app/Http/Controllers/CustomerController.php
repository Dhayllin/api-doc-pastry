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

            $ordersCustomer = $customer->orders()->get();
            $customer->orders = $customer->orders()->get();

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
        $rules['email'] = 'unique:customers,email,'.$id;

        $validator = Validator::make( $request->all(),$rules);

        if ($validator->fails()) {
            return  $validator->messages()->first();
        }

        $customer = $this->customer->where('id', $id)->first();

        $dataForm = $request->all();

        DB::beginTransaction();
        try
        {
            if ($customer) {
                $customer->update($dataForm);
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = $this->customer->where('id', $id)->first();

        DB::beginTransaction();
        try
        {
            if ($customer) {
                $customer->delete();
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
