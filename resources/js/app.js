import './bootstrap';

$(document).ready(function () {
   $('#table_notes').dataTable({
      lengthMenu: [10],
      ordering: false,
      "language": {
         "info": "Mostrando _END_ de _TOTAL_ registros",
         "search": "Buscar:",
         "zeroRecords": "Sin resultados encontrados",
         "lengthMenu": "Mostrar _MENU_ entradas",
         "paginate": {
            "first": "<<",
            "last": ">>",
            "next": ">",
            "previous": "<",

         }
      }
   });
   $('#table_areas').dataTable({
      lengthMenu: [10],
      ordering: false,
      "language": {
         "info": "Mostrando _END_ de _TOTAL_ registros",
         "search": "Buscar:",
         "zeroRecords": "Sin resultados encontrados",
         "lengthMenu": "Mostrar _MENU_ entradas",
         "paginate": {
            "first": "<<",
            "last": ">>",
            "next": ">",
            "previous": "<",

         }
      }
   });
   $('#table_ovens').dataTable({
      lengthMenu: [10],
      ordering: false,
      "language": {
         "info": "Mostrando _END_ de _TOTAL_ registros",
         "search": "Buscar:",
         "zeroRecords": "Sin resultados encontrados",
         "lengthMenu": "Mostrar _MENU_ entradas",
         "paginate": {
            "first": "<<",
            "last": ">>",
            "next": ">",
            "previous": "<",

         }
      }
   });
   $('#table_users').dataTable({
      lengthMenu: [10],
      ordering: false,
      "language": {
         "info": "Mostrando _END_ de _TOTAL_ registros",
         "search": "Buscar:",
         "zeroRecords": "Sin resultados encontrados",
         "lengthMenu": "Mostrar _MENU_ entradas",
         "paginate": {
            "first": "<<",
            "last": ">>",
            "next": ">",
            "previous": "<",

         }
      }
   });
});
