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
      "sEmptyTable": "テーブルにデータがありません",
      "sInfo": " _TOTAL_ 件中 _START_ から _END_ まで表示",
      "sInfoEmpty": " 0 件中 0 から 0 まで表示",
      "sInfoFiltered": "（全 _MAX_ 件より抽出）",
      "sInfoPostFix": "",
      "sInfoThousands":  ",",
      "sLengthMenu": "_MENU_ 件表示",
      "sLoadingRecords": "読み込み中...",
      "sProcessing": "処理中...",
      "sSearch": "検索:",
      "sZeroRecords": "一致するレコードがありません",
      "oPaginate": {
        "sFirst": "先頭",
        "sLast": "最終",
        "sNext": "次",
        "sPrevious": "前"
      },
      "oAria": {
        "sSortAscending":  ": 列を昇順に並べ替えるにはアクティブにする",
        "sSortDescending": ": 列を降順に並べ替えるにはアクティブにする"
      }
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
