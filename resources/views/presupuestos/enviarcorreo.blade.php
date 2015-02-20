<div class="modal-dialog modal-lg">
    <div class="modal-content">
        {!!Form::open(array('url'=>'presupuestos/enviarcorreo', 'class'=>'saveajax', 'data-reload'=>true))!!}
        {!!Form::hidden('id', $presupuesto->id)!!}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Cerrar</span>
            </button>
            <h4 class="modal-title">Enviar presupuesto por email</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                {!!Form::bootstrap('correo', $cliente->correo, 'Correo Destinatario')!!}
                {!!Form::bootstrap('asunto','', 'Asunto')!!}
            </div>
            <div class="row">
                {!!Form::bootstrap('mensaje','', 'Mensaje del correo', 12, true)!!}
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
        {!!Form::close()!!}
    </div>
</div>
{!!HTML::script('js/ckeditor/ckeditor.js')!!}