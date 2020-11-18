<?php

namespace App\Http\Controllers;

use App\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InventarioImport;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
            FROM inventarios
            LEFT JOIN estados ON estado_id = estados.id
            LEFT JOIN municipios ON municipio_id = municipios.id
            LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
            LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
            LEFT JOIN marcas ON inventarios.marca_id = marcas.id
            LEFT JOIN users ON user_id = users.id
            ORDER BY inventarios.id DESC");

        echo json_encode($inventarios); // para pasar en json
    }


    public function equiposno()
    {
        $inventariow = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at
        FROM inventarios
        LEFT JOIN estados ON estado_id = estados.id
        LEFT JOIN municipios ON municipio_id = municipios.id
        LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
        LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
        LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
        LEFT JOIN marcas ON inventarios.marca_id = marcas.id
        LEFT JOIN users ON user_id = users.id
        WHERE estatu_equipo_id = '3' OR estatu_equipo_id='4'
    
        ORDER BY inventarios.id DESC");

        echo json_encode($inventariow); // para pasar en json
    }
    

    public function InventarioDetallada($inventario_id)
    {
        $inventario_detallado = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
            FROM inventarios
            LEFT JOIN estados ON estado_id = estados.id
            LEFT JOIN municipios ON municipio_id = municipios.id
            LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
           
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
            LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
            LEFT JOIN marcas ON inventarios.marca_id = marcas.id
            LEFT JOIN users ON user_id = users.id
            WHERE inventarios.id = ?

            ", [$inventario_id]);

        echo json_encode($inventario_detallado); // para pasar en json

    }
    


    //ESTADISTICAS //

public function EstatusEquiposInventariosContar()
    {
        $inventariocontar = DB::select("SELECT COUNT(*) as equipos, estatu_equipo_id, estatu_equipo 
            FROM inventarios 
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id 
            GROUP BY estatu_equipo_id, estatu_equipo");

        echo json_encode($inventariocontar); // para pasar en json
    }


     public function EstatusEquiposInventariosContarEstados($inventario_id)
    {
        $inventariocontar = DB::select("SELECT COUNT(*) as equipos, estatu_equipo_id, estatu_equipo 
            FROM inventarios 
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id 
            WHERE estado_id = ?
            GROUP BY estatu_equipo_id, estatu_equipo", [$inventario_id]);

        echo json_encode($inventariocontar); // para pasar en json
    }





    public function EstatusEquiposInventariosContarCentroSalud($inventario_id)
    {
        $inventariocontar = DB::select("SELECT COUNT(*) as equipos, estatu_equipo_id, estatu_equipo 
            FROM inventarios 
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id 
            WHERE centro_salud_id = ?
            GROUP BY estatu_equipo_id, estatu_equipo", [$inventario_id]);

        echo json_encode($inventariocontar); // para pasar en json
    }







 public function totalInventario()
    {
        $inventarios = DB::select("SELECT COUNT(*) as inventarios
                                   FROM inventarios");
        echo json_encode($inventarios); // para pasar en json

    }


    public function totalInventarioPorEstados($inventario_id)
    {
        $inventarios = DB::select("SELECT COUNT(*) as inventarios
                                   FROM inventarios
                                   WHERE estado_id = ?", [$inventario_id]);
        echo json_encode($inventarios); // para pasar en json

    }


public function totalInventarioPorCentroSalud($inventario_id)
    {
        $inventarios = DB::select("SELECT COUNT(*) as inventarios
                                   FROM inventarios
                                   WHERE centro_salud_id = ?", [$inventario_id]);
        echo json_encode($inventarios); // para pasar en json

    }





    
    //ESTADISTICAS

    
     public function store(Request $request)
    {
        $inventario = new Inventario();
        $inventario->estado_id = $request->input('estado_id');
        $inventario->municipio_id = $request->input('municipio_id');
        $inventario->centro_salud_id = $request->input('centro_salud_id');
        $inventario->servicio_medico = $request->input('servicio_medico');
        $inventario->piso = $request->input('piso');
        $inventario->equipo_id = $request->input('equipo_id');
        $inventario->marca_id = $request->input('marca_id');
        $inventario->modelo = $request->input('modelo');
        $inventario->serial = $request->input('serial');
        $inventario->numero_bien_nacional = $request->input('numero_bien_nacional');
        $inventario->proveedor = $request->input('proveedor');
        $inventario->estatu_equipo_id = $request->input('estatu_equipo_id');
        $inventario->observacion = $request->input('observacion');
        $inventario->reparado = $request->input('reparado');
        $inventario->fecha_instalacion = $request->input('fecha_instalacion');
        $inventario->proveedor_servicio = $request->input('observacion');
        $inventario->user_id = $request->input('user_id');


  
      

        $inventario->save(); // para guardar en json

        echo json_encode($inventario); // para pasar en json
    }

   

    public function show($inventario_id)
    {
        $inventarios =Inventario::find($inventario_id);
        echo json_encode($inventarios);
    }
      

   
    public function update(Request $request, $inventario_id)
    {
        $inventario =Inventario::find($inventario_id);
        $inventario->estado_id = $request->input('estado_id');
        $inventario->municipio_id = $request->input('municipio_id');
        $inventario->centro_salud_id = $request->input('centro_salud_id');
        $inventario->servicio_medico = $request->input('servicio_medico');
        $inventario->piso = $request->input('piso');
        $inventario->equipo_id = $request->input('equipo_id');
        $inventario->marca_id = $request->input('marca_id');
        $inventario->modelo = $request->input('modelo');
        $inventario->serial = $request->input('serial');
        $inventario->numero_bien_nacional = $request->input('numero_bien_nacional');
        $inventario->proveedor = $request->input('proveedor');
        $inventario->estatu_equipo_id = $request->input('estatu_equipo_id');
        $inventario->observacion = $request->input('observacion');
        $inventario->reparado = $request->input('reparado');
        $inventario->fecha_instalacion = $request->input('fecha_instalacion');
        $inventario->proveedor_servicio = $request->input('observacion');
        $inventario->user_id = $request->input('user_id');
        
      
        $inventario->save(); // para guardar en json

        echo json_encode($inventario); // para pasar en json
    }

  
    public function destroy($inventario_id)
    {
        $inventario =Inventario::find($inventario_id);
        $inventario->delete();
    }






// QUERY PARA VER EL LISTADO DE INVENTARIO POR CENTRO DE SALUD

public function InventarioPorCentroSalud($inventario_id)
    {
        $inventario_detallado = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo_id, marca_id, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
            FROM inventarios 
            LEFT JOIN estados ON estado_id = estados.id
            LEFT JOIN municipios ON municipio_id = municipios.id
            LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
          
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
            LEFT JOIN users ON user_id = users.id
            WHERE inventarios.centro_salud_id = ?
             ORDER BY inventarios.id DESC
            ", [$inventario_id]);

        echo json_encode($inventario_detallado); // para pasar en json

    }

// ímportar masivo excel

public function import() 

    {
      $data = Excel::import(new InventarioImport,request()->file('file'));

    echo json_encode($data);

        

    }



    public function inventarioMarcaDuplicado($marca_id, $serial)
    {
        $invetariomarca = DB::select("SELECT  marca_id, serial 
            FROM inventarios 
            WHERE marca_id = ? AND serial = ?
           ",[$marca_id, $serial]  );

        echo json_encode($invetariomarca); // para pasar en json
    }


    public function TablaEquipos()
    {
        $tabla = DB::select("SELECT e.estado,
        (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (1,2) AND e.id=estado_id) AS equipos_operativos,
        (SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (3,4) AND e.id=estado_id) AS equipos_inoperativos,
        (SELECT count(estatu_equipo_id) FROM inventarios WHERE e.id=estado_id) AS total_equipos,
        (((SELECT count(estatu_equipo_id) FROM inventarios WHERE estatu_equipo_id in (1,2) AND e.id=estado_id) * 100)/ (SELECT count(estatu_equipo_id) FROM inventarios where e.id=estado_id)) AS coeficiente_disponibilidad_tecnica
        FROM estados AS e
        INNER JOIN inventarios AS i on i.estado_id=e.id
        INNER JOIN estatu_equipos AS h on h.id=i.estatu_equipo_id
        GROUP BY e.estado, equipos_operativos, equipos_inoperativos
        ORDER BY e.estado");

        echo json_encode($tabla); // para pasar en json
    }





    //REPORTES PDF //


    public function ReporteInventarioEstadal($estado_id)
    {
        $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
            FROM inventarios
            LEFT JOIN estados ON estado_id = estados.id
            LEFT JOIN municipios ON municipio_id = municipios.id
            LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
            LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
            LEFT JOIN marcas ON inventarios.marca_id = marcas.id
            LEFT JOIN users ON user_id = users.id
            WHERE inventarios.estado_id = ?
            ORDER BY inventarios.id DESC", [$estado_id] );

        echo json_encode($inventarios); // para pasar en json
    }


    public function ReporteInventarioMunicipal($municipio_id)
    {
        $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
            FROM inventarios
            LEFT JOIN estados ON estado_id = estados.id
            LEFT JOIN municipios ON municipio_id = municipios.id
            LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
            LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
            LEFT JOIN marcas ON inventarios.marca_id = marcas.id
            LEFT JOIN users ON user_id = users.id
            WHERE inventarios.municipio_id = ?
            ORDER BY inventarios.id DESC", [$municipio_id] );

        echo json_encode($inventarios); // para pasar en json
    }

    public function ReporteInventarioCentroSalud($centro_salud_id)
    {
        $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
            FROM inventarios
            LEFT JOIN estados ON estado_id = estados.id
            LEFT JOIN municipios ON municipio_id = municipios.id
            LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
            LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
            LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
            LEFT JOIN marcas ON inventarios.marca_id = marcas.id
            LEFT JOIN users ON user_id = users.id
            WHERE inventarios.centro_salud_id = ?
            ORDER BY inventarios.id DESC", [$centro_salud_id] );

        echo json_encode($inventarios); // para pasar en json
    }
    
    

      //REPORTES PDF ESTADOS Y ESTATUS //


      public function ReporteInventarioEstadalPorEstatus($estado_id, $estatu_equipo_id)
      {
          $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
              FROM inventarios
              LEFT JOIN estados ON estado_id = estados.id
              LEFT JOIN municipios ON municipio_id = municipios.id
              LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
              LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
              LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
              LEFT JOIN marcas ON inventarios.marca_id = marcas.id
              LEFT JOIN users ON user_id = users.id
              WHERE inventarios.estado_id = ? AND inventarios.estatu_equipo_id = ?
              ORDER BY inventarios.id DESC", [$estado_id, $estatu_equipo_id] );
  
          echo json_encode($inventarios); // para pasar en json
      }
  
  
      public function ReporteInventarioMunicipalPorEstatus($municipio_id, $estatu_equipo_id)
      {
          $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
              FROM inventarios
              LEFT JOIN estados ON estado_id = estados.id
              LEFT JOIN municipios ON municipio_id = municipios.id
              LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
              LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
              LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
              LEFT JOIN marcas ON inventarios.marca_id = marcas.id
              LEFT JOIN users ON user_id = users.id
              WHERE inventarios.municipio_id = ? AND inventarios.estatu_equipo_id = ?
              ORDER BY inventarios.id DESC", [$municipio_id, $estatu_equipo_id] );
  
          echo json_encode($inventarios); // para pasar en json
      }
  
      public function ReporteInventarioCentroSaludPorEstatus($centro_salud_id, $estatu_equipo_id)
      {
          $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
              FROM inventarios
              LEFT JOIN estados ON estado_id = estados.id
              LEFT JOIN municipios ON municipio_id = municipios.id
              LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
              LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
              LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
              LEFT JOIN marcas ON inventarios.marca_id = marcas.id
              LEFT JOIN users ON user_id = users.id
              WHERE inventarios.centro_salud_id = ? AND inventarios.estatu_equipo_id = ?
              ORDER BY inventarios.id DESC", [$centro_salud_id, $estatu_equipo_id] );
  
          echo json_encode($inventarios); // para pasar en json
      }



       //REPORTES PDF ESTADOS Y REPARADO //


       public function ReporteInventarioEstadalPorReparados($estado_id, $reparado)
       {
           $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
               FROM inventarios
               LEFT JOIN estados ON estado_id = estados.id
               LEFT JOIN municipios ON municipio_id = municipios.id
               LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
               LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
               LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
               LEFT JOIN marcas ON inventarios.marca_id = marcas.id
               LEFT JOIN users ON user_id = users.id
               WHERE inventarios.estado_id = ? AND inventarios.reparado = ?
               ORDER BY inventarios.id DESC", [$estado_id, $reparado] );
   
           echo json_encode($inventarios); // para pasar en json
       }
   
   
       public function ReporteInventarioMunicipalPorReparados($municipio_id, $reparado)
       {
           $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
               FROM inventarios
               LEFT JOIN estados ON estado_id = estados.id
               LEFT JOIN municipios ON municipio_id = municipios.id
               LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
               LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
               LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
               LEFT JOIN marcas ON inventarios.marca_id = marcas.id
               LEFT JOIN users ON user_id = users.id
               WHERE inventarios.municipio_id = ? AND inventarios.reparado = ?
               ORDER BY inventarios.id DESC", [$municipio_id, $reparado] );
   
           echo json_encode($inventarios); // para pasar en json
       }
   
       public function ReporteInventarioCentroSaludPorReparados($centro_salud_id, $reparado)
       {
           $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
               FROM inventarios
               LEFT JOIN estados ON estado_id = estados.id
               LEFT JOIN municipios ON municipio_id = municipios.id
               LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
               LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
               LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
               LEFT JOIN marcas ON inventarios.marca_id = marcas.id
               LEFT JOIN users ON user_id = users.id
               WHERE inventarios.centro_salud_id = ? AND inventarios.reparado = ?
               ORDER BY inventarios.id DESC", [$centro_salud_id, $reparado] );
   
           echo json_encode($inventarios); // para pasar en json
       }





        // REPORTE PARA BUSCAR UN LIKE POR EQUIPO DEL INVENTARIO


       public function ReporteInventarioBuscarEquipo($equipo)
       {
           $equipo = '%'.$equipo.'%';
           $inventarios = DB::select("SELECT inventarios.id, estado, municipio, centro_salud, servicio_medico, piso, equipo, marca, modelo, serial, numero_bien_nacional, proveedor, estatu_equipo, observacion, reparado, fecha_instalacion, proveedor_servicio, name, inventarios.created_at 
               FROM inventarios
               LEFT JOIN estados ON estado_id = estados.id
               LEFT JOIN municipios ON municipio_id = municipios.id
               LEFT JOIN centro_salud ON centro_salud_id = centro_salud.id
               LEFT JOIN estatu_equipos ON estatu_equipo_id = estatu_equipos.id
               LEFT JOIN equipos ON inventarios.equipo_id = equipos.id
               LEFT JOIN marcas ON inventarios.marca_id = marcas.id
               LEFT JOIN users ON user_id = users.id
               WHERE equipos.equipo LIKE ?
               ORDER BY inventarios.id DESC", [$equipo] );
   
           echo json_encode($inventarios); // para pasar en json
       }
   




}
