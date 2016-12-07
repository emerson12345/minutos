var usersTable = $("#cuadernos-table").DataTable({
    "lengthMenu": [5,10, 25, 50],
    "processing":true,
    "serverSide":true,
    "ajax": $("#cuadernos-table").data("url"),
    "columns":[
        {data:'cua_nombre'},
        {
            data:function(row, type, val, meta){
                var fecha = row.cua_fec_alta;
                if(moment(row.cua_fec_alta).isValid())
                    fecha = moment(row.cua_fec_alta).format('DD/MM/YYYY HH:mm:ss');
                return fecha;
            }
        },
        {
            data:function(row, type, val, meta){
                var fecha = row.cua_fec_mod;
                if(moment(row.cua_fec_mod).isValid())
                    fecha = moment(row.cua_fec_mod).format('DD/MM/YYYY HH:mm:ss');
                return fecha;
            }
        },
        {
            data:function (row,type,val,meta) {
                var valReturn = "";
                if(row.cua_seleccionable == 1)
                    valReturn = "<span class='label text-green'>VIGENTE</span>";
                else
                    valReturn = "<span class='label text-red'>NO VIGENTE</span>"
                return valReturn;
            },
            orderable:false
        },
        {
            data:function (row,type,val,meta) {
                return '<a class="btn btn-edit btn-xs btn-primary" href="'+row.edit_url+'" title="Editar"><i class="fa fa-edit"></i> </a>'
            },
            orderable:false
        }
    ]
});