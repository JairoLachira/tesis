<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\District;
use App\Card;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function config()
    {
        $districts = District::all();
        return view('user.config', \compact('districts'));
    }

    public function update(Request $request)
    {
        //Conseguir usuario identificado
        $user = \Auth::user();
        $id = $user->id;

        //validación del formulario
        $validate = $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'password' => ['string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'telephone' => ['max:20'],
            'address' => ['max:255'],
        ]);

        //recoger los datos del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $email = $request->input('email');
        $telephone = $request->input('telephone');
        $address = $request->input('address');
        $district_id = $request->input('district_id');

        $password = $request->input('newpassword');
        $repeatpassword = $request->input('repeatpassword');

        //asignar nuevos valores al objeto del usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->email = $email;
        $user->telephone = $telephone;
        $user->address = $address;
        $user->district_id = $district_id;

        if(isset($password) && isset($repeatpassword))
        {
            if($password==$repeatpassword)
            {
                $user->password = \bcrypt($password);
            }
            else
            {
                return redirect()->route('config')
                ->with(['error_password_no_coinciden'=>'Las contraseñan no coinciden']);
            }
        }

        //Recoger y Subir la imagen
        $image_path = $request->file('image_path');
        if ($image_path)
        {
            //Coloco nombre único
            $image_path_name = time().$image_path->getClientOriginalName();

            //Guardo en la carpeta Storage (storage/app/users)
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            //Seteo el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }

        //Ejecutar consulta y cambios en la base de datos
        $user->update();

        //Redireccionar a la vista con un mensaje
        return redirect()->route('config')
                         ->with(['message'=>'Usuario Actualizado Correctamente']);
    }

    public function getImage($filename)
    {
        $file = Storage::disk('users')->get($filename);
        return new Response($file,200);
    }

    public function getDatosTarjeta()
    {
        //Conseguir usuario identificado
        $user = \Auth::user();
        $id = $user->id;
        $card = Card::where('user_id','=',$id)->get();

        if(count($card)>0)
        {
            echo json_encode($card);
        }
        else
        {
            echo json_encode("no");
        }
    }

    public function getDatosTarjetaOne($id)
    {
        $card = Card::where('id','=',$id)
        ->first();

        echo json_encode($card);
    }


}
