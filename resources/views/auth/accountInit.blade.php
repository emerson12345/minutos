<div class="row">
    <div class="col-md-12">
        {{Form::open()}}
            {!! Form::select('selectCenter',\Sicere\Models\Institucion::all()->pluck('inst_nombre','inst_id')) !!}
            <button type="submit">
                Seleccionar
            </button>
        {{Form::close()}}
    </div>
</div>
