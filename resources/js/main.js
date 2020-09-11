$(function () {

  var table = $('#dataList').DataTable({
    "paging":   true,
    "pagingType": 'numbers',
    "ordering": false,
    "info":     false,
    "pageLength" : 10,
    "columnDefs": [ {
      'checkboxes': {
        'selectRow': true
       }
    }],
    'select': {
      'style': 'multi',
      'selector': '.dataList__inputSelect'
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Japanese.json"
    },
    initComplete: function () {
      $('.js--searchFilterSubmit').on('click', function () {
        table.search($('.js--searchInputText').val()).draw();
      });

      $('.dataListSearchAction').submit(function(){
            table.search($('.js--searchInputText').val()).draw();
            return false;
      });

      // Delete uneccessary modules
      $('.dataTables_paginate').appendTo('.dashboardPage__pagination');
      $('.dataTables_empty, .dataTables_length, .dataTables_filter').remove();

      // Select All Rows
      $('.js--selectAll').on('click', function(e) {
        if ($(this).is( ":checked" )) {
            table.rows({page: 'current'}).select();
            $('.dataList__inputSelect').prop('checked', true);
        } else {
            table.rows({page: 'current'}).deselect();
            $('.dataList__inputSelect').prop('checked', false);
        }
      });
    }
  });
});
