<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use DB;
use Log;

class ProductController extends Controller
{

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->all();

        return response()->json(['data', $products], 200);
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
        $validator = Validator::make($request->all(), $this->product->rules());

        if ($validator->fails()) {
             return  $validator->messages()->first();
        }

        $dataForm =  $request->all();

        DB::beginTransaction();
        try
        {
            $pathPhoto = $dataForm['photo']->store('images');

            $this->product->create([
                'name' => $dataForm['name'],
                'price' => $dataForm['price'],
                'photo' =>  $pathPhoto
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $product = $this->product->where('id', $id)->first();
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['data' => 'product not found']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product = $this->product->where('id', $id)->first();
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['data' => 'product not found']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make( $request->all(), $this->product->rules());

        if ($validator->fails()) {
             return  $validator->messages()->first();
        }

        $product = $this->product->where('id', $id)->first();
        $dataForm =  $request->all();

        DB::beginTransaction();
        try
        {
            if ($product) {

                if($dataForm['photo']){
                    Storage::delete($product['photo']);
                    $pathPhoto = $dataForm['photo']->store('images');
                }


                $product->update([
                    'name' => $dataForm['name'],
                    'price' => $dataForm['price'],
                    'photo' =>  $pathPhoto
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->product->where('id', $id)->first();

        DB::beginTransaction();
        try
        {
            if ($product) {

                Storage::delete($product['photo']);

                $product->delete();
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
