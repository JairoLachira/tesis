<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Valoration;
use App\Order;

class ValorationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // $reservo=$this->consultReserva($request->user_id,$request->restaurant_id);
        $reservo=$this->consultReserva($request);
        if ($reservo=='true') {
            $datos=$this->consult($request->user_id,$request->restaurant_id);
            $valoration=new Valoration();

            if ($datos) {
                $valoration = Valoration::where('user_id','=',$request->user_id)
                ->where('restaurant_id','=',$request->restaurant_id)
                ->first();
            }

            $valoration->user_id=$request->user_id;
            $valoration->restaurant_id=$request->restaurant_id;
            $valoration->score=$request->score;

            if($datos){
                $valoration->update();
            }else{
                $valoration->save();
            }
            echo '1';
        }else{
            echo '0';
        }

    }

    // private function consultReserva($id_user,$id_restaurant){
    //         $datos = Order::all()
    //         ->where('user_id',$id_user)
    //         ->where('restaurant_id',$id_restaurant)
    //         ->where('state','completado')
    //         ->first();
    //
    //         $var=true;
    //         if ($datos==null) {
    //             $var=false;
    //         }
    //         return $var;
    // }

    public function consultReserva(Request $request){
            $datos = Order::all()
            ->where('user_id',$request->user_id)
            ->where('restaurant_id',$request->restaurant_id)
            ->where('state','completado')
            ->first();

            $var='true';
            if ($datos==null) {
                $var='false';
            }
            return $var;
    }

    private function consult($id_user,$id_restaurant){
            $datos = Valoration::all()
            ->where('user_id',$id_user)
            ->where('restaurant_id',$id_restaurant)
            ->first();

            $var=true;
            if ($datos==null) {
                $var=false;
            }
            return $var;
    }

    public function obtnerCali(Request $request){
            $datos = Valoration::all()
            ->where('user_id',$request->user_id)
            ->where('restaurant_id',$request->restaurant_id)
            ->first();
            if ($datos!=null) {
                echo $datos->score;
            }
    }

    public function obtnerCaliR(Request $request){

            $datos = Valoration::all()
            ->where('restaurant_id',$request->restaurant_id);

            if ($datos!='[]') {
                $puntaje=0;
                $cantidad=count($datos);
                foreach ($datos as $key => $value) {
                    $puntaje+=$value['score'];
                }
                return ($puntaje/$cantidad);
            }else{
                return 'null';
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
