<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\ArticuloPresupuesto;
use App\Configuracion;
use App\Configuration;
use App\DetalleArticulo;
use App\Http\Requests\EnviarCorreoRequest;
use App\Persona;
use App\Presupuesto;
use HTML2PDF;
use HTML2PDF_exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PresupuestosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex(Request $req)
    {
        $data['presupuestos'] = Presupuesto::eagerLoad()->filtrar($req->all())->get();
        $data['evento'] = $req->get('evento', null);
        $data['estatus'] = isset(Presupuesto::$estatuses[$req->get('estatus')]) ? Presupuesto::$estatuses[$req->get('estatus')] : 'Todos';

        return view('presupuestos.index', $data);
    }

    public function getModificar($id = 0)
    {
        $data['presupuesto'] = Presupuesto::findOrNew($id);
        if ($data['presupuesto']->puedeModificar()) {
            $data['clientes'] = Persona::comboClientes();
            $data['articulos'] = Articulo::eagerLoad()->get();
            $data['articulosPre'] = $data['presupuesto']->articulos;

            return view('presupuestos.modificar', $data);
        }

        return redirect('presupuestos')->with('mensaje',
            'No se puede editar un presupuesto que no este en elaboración');
    }

    public function postModificar(Request $req)
    {
        $presupuesto = Presupuesto::findOrNew($req->get('id', 0));
        $presupuesto->fill($req->all());
        if ($presupuesto->save()) {
            return Redirect::to('presupuestos/modificar/' . $presupuesto->id)->with('mensaje',
                'Se guardó el presupuesto correctamente');
        }

        return Redirect::back()->withInput()->withErrors($presupuesto->getErrors());
    }

    public function postAgregararticulo(Request $req)
    {
        $presupuesto = Presupuesto::findOrFail($req->get('id', 0));
        $articulo = Articulo::findOrFail($req->get('articulo_id', 0));
        $artPre = new ArticuloPresupuesto();
        $artPre->presupuesto()->associate($presupuesto);
        $artPre->articulo()->associate($articulo);
        $artPre->save();
        $data['mensaje'] = "Se agregó el articulo al presupuesto correctamente";
        $data['vista'] = $this->getModificar($req->get('id'))->render();

        return response()->json($data);
    }

    public function postActualizararticulo(Request $req)
    {
        $artPre = ArticuloPresupuesto::findOrFail($req->get('id'));
        $artPre->fill($req->all());
        if ($artPre->save()) {
            $data['mensaje'] = "Se guardaron los datos correctamente";
            $data['presupuesto'] = $artPre->presupuesto;
            $data['articulo'] = $artPre;

            return response()->json($data);
        }

        return response()->json(['errores' => $artPre->getError()], 400);
    }

    public function deleteArticulo($id)
    {
        $artPre = ArticuloPresupuesto::findOrFail($id);
        $articulo_id = $artPre->articulo_id;
        $artPre->delete();
        $data['mensaje'] = "Se eliminó el articulo del presupuesto correctamente";
        $data['vista'] = $this->getModificar($articulo_id)->render();

        return response()->json($data);
    }

    public function postOrdenar(Request $req)
    {
        ArticuloPresupuesto::ordenar($req->get('filas'));
    }

    public function getEnviar($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $presupuesto->enviado();

        return Redirect::to('presupuestos?estatus=2')->with('mensaje',
            'Se marcó el presupuesto como enviado al cliente correctamente.');
    }

    public function getAprobado($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $presupuesto->aprobado();

        return Redirect::to('presupuestos?estatus=' . $presupuesto->estatus)->with('mensaje',
            'Se marcó el presupuesto como aprobado correctamente.');
    }

    public function getPagado($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $presupuesto->pagado();

        return Redirect::to('presupuestos?estatus=5')->with('mensaje',
            'Se marcó el presupuesto como pagado correctamente.');
    }

    public function getAnular($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $presupuesto->anular();

        return Redirect::to('presupuestos?estatus=6')->with('mensaje',
            'Se marcó el presupuesto como anulado correctamente.');
    }

    public function getReversar($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $presupuesto->reversar();

        return Redirect::to('presupuestos?estatus=4')->with('mensaje',
            'Se marcó el presupuesto como aprobado correctamente.');
    }

    public function getImprimir($id, $saveLocal = false)
    {
        require_once(app_path() . '/Helpers/pdf/html2pdf.class.php');
        $data['presupuesto'] = Presupuesto::findOrFail($id);
        $content = view('reportes.html2pdf.presupuesto', $data)->render();
        try {
            $html2pdf = new HTML2PDF('P', 'letter', 'es');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content);
            if ($saveLocal) {
                $html2pdf->Output(storage_path('app/presupuesto.pdf'), 'F');
            } else {
                $html2pdf->Output('presupuesto.pdf');
            }
        } catch (HTML2PDF_exception $e) {
            echo $e;
        }
    }

    public function getEnviarcorreo($id)
    {
        $data['presupuesto'] = Presupuesto::findOrFail($id);
        $data['cliente'] = $data['presupuesto']->cliente;

        return view('presupuestos.enviarcorreo', $data);
    }

    public function postEnviarcorreo(EnviarCorreoRequest $request)
    {
        $this->getImprimir($request->get('id'), true);
        $data['mensaje'] = $request->get('mensaje');
        \Mail::send('emails.presupuesto', $data, function ($message) use ($request) {
            $from = Configuracion::get('remitente-correo', 'Remitente de los correos a enviar');
            $from_name = Configuracion::get('remitente-correo', 'Nombre del remitente de los correos a enviar');

            $message->from($from, $from_name);
            $message->to($request->get('correo'))->subject($request->get('asunto'))->cc(\Auth::user()->email);
            $message->attach(storage_path('app/presupuesto.pdf'));
        });

        return response()->json(['mensaje' => 'Se envio el correo correctamente']);
    }

    public function getAsignarproveedores($presupuesto_id)
    {
        $data['presupuesto'] = Presupuesto::findOrFail($presupuesto_id);
        $data['detalles'] = $data['presupuesto']->detalles;

        return view('presupuestos.asignarproveedores', $data);
    }

    public function getProveedoresdisponibles($detalle_id)
    {

    }

    public function deleteAsignarproveedores($detalle_id)
    {
        $detalle = DetalleArticulo::findOrFail($detalle_id);
        $detalle->ind_confirmado = false;
        $detalle->proveedor_id = null;
        $detalle->save();
        $data['vista'] = $this->getAsignarproveedores($detalle->articuloPresupuesto->presupuesto_id)->render();
        $data['mensaje'] = "Se removió el proveedor correctamente";

        return response()->json($data);
    }

}
