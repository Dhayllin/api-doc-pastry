<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class OrderController extends Controller
{

    private $order;
    private $customer;
    private $product;

    public function __construct(Order $order, Customer $customer, Product $product)
    {
        $this->order = $order;
        $this->customer = $customer;
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->order->all();

        return response()->json(['data', $orders], 200);
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
        $validator = Validator::make($request->all(), $this->order->rules());

        if ($validator->fails()) {
             return  $validator->messages()->first();
        }

        $dataForm =  $request->all();


        // validate customer exist
        $customer = $this->customer->where('id', $dataForm['customer_id'])->first();
        if(!$customer){
            return response()->json(['data' => 'customer not found']);
        }

        //validate order exist
        foreach( $dataForm['product_ids'] as $product_id ){
            $product = $this->product->where('id', $product_id)->first();
            if(!$product){
                return response()->json(['data' => 'product not found']);
            }
        }


        DB::beginTransaction();
        try
        {
            $this->order->create([
                'customer_id' => $dataForm['customer_id'],
                'product_ids' => json_encode($dataForm['product_ids'])
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->order->where('id', $id)->first();
        if ($order) {
            return response()->json($order);
        } else {
            return response()->json(['data' => 'order not found']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = $this->order->where('id', $id)->first();
        if ($order) {
            return response()->json($order);
        } else {
            return response()->json(['data' => 'order not found']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make( $request->all(), $this->order->rules());

        if ($validator->fails()) {
             return  $validator->messages()->first();
        }

        $order = $this->order->where('id', $id)->first();

        $dataForm =  $request->all();

        // validate customer exist
        $customer = $this->customer->where('id', $dataForm['customer_id'])->first();
        if(!$customer){
            return response()->json(['data' => 'customer not found']);
        }

        //validate order exist

        foreach( $dataForm['product_ids'] as $product_id ){
            $product = $this->product->where('id', $product_id)->first();
            if(!$product){
                return response()->json(['data' => 'product not found']);
            }
        }

        DB::beginTransaction();
        try
        {
            if ($order) {
                $order->update([
                    'customer_id' => $dataForm['customer_id'],
                    'product_ids' => json_encode($dataForm['product_ids'])
                ]);
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
