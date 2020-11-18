<?php


namespace App\Http\Controllers;

use App\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos =Equipo::get();
        echo json_encode($equipos);
    }
    

    
     public function store(Request $request)
    {
        $equipo = new Equipo();
        $equipo->equipo = $request->input('equipo');
        
  
      

        $equipo->save(); // para guardar en json

        echo json_encode($equipo); // para pasar en json
    }

   

    public function show($equipo_id)
    {
        $equipos =Equipo::find($equipo_id);
        echo json_encode($equipos);
    }
      

   
    public function update(Request $request, $equipo_id)
    {
        $equipo =Equipo::find($equipo_id);
        $equipo->equipo = $request->input('equipo');
      
        $equipo->save(); // para guardar en json

        echo json_encode($equipo); // para pasar en json
    }

  
    public function destroy($equipo_id)
    {
        $equipo =Equipo::find($equipo_id);
        $equipo->delete();
    }
}
