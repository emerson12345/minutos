var usersTable = $("#cuadernos-table").DataTable({
    "lengthMenu": [5,10, 25, 50],
    "processing":true,
    "serverSide":true,
    "ajax": $("#cuadernos-table").data("url"),
    "columns":[
        {data:'cua_nombre'},
        {data:'cua_fec_alta'},
        {data:'cua_fec_mod'},
        {
            data:function (row,type,val,meta) {
                var valReturn = "";
                if(row.cua_seleccionable == 1)
                    valReturn = "<span class='label label-primary'>VIGENTE</span>";
                else
                    valReturn = "<span class='label label-danger'>NO VIGENTE</span>"
                return valReturn;
            },
            orderable:false
        },
        {
            data:function (row,type,val,meta) {
                return '<a class="btn btn-edit btn-xs btn-primary" href="update/'+row.cua_id+'"><i class="fa fa-edit"></i> Editar</a>'
            },
            orderable:false
        }
    ]
});