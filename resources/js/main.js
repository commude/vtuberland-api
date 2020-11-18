$(function () {
    var table = $('#purchaseDataList').DataTable({
      "paging": true,
      "pagingType": 'numbers',
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "pageLength" : 20,
      "fixedHeader" : true,
      "scrollY": "530px",
      "scrollX": "100%",
      'searching': true,
      'processing': false,
      'serverSide': true,
      'ajax':{
        'url': $(".api_route").html(),
        'dataType': 'json',
        'type': 'GET',
        "dataSrc": function ( json ) {
          $('.dataListStatus__text').html("合計金額：" + json.totalPrice + "円");
          return json.data;
        }
      },
      'columns': [
        { 'data': 'purchase_date' },
        { 'data': 'user_name' },
        { 'data': 'content' },
        { 'data': 'price' },
      ],
      'select': {
        'style': 'multi',
        'selector': '.dataList__inputSelect'
      },
      "columnDefs": [
        {'targets': 0, 'className': "dataList__itemPurchaseDate"},
        {'targets': 1, 'className': "dataList__itemBuyerAccount"},
        {'targets': 2, 'className': "dataList__itemBuyerContent"},
        {'targets': 3, 'className': "dataList__itemPurchasePrice"},
        { 'searchable': false, 'targets': [0, 2, 3] },
      ],

      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Japanese.json"
      },
      "initComplete": function(settings, json) {

        $('.js--searchFilterSubmit').on('click', function () {
          table.column(1).search($('.js--searchInputText').val()).draw();
        });

        $('.js--searchInputText').on("keydown", function (e) {
            var key = e.which;
            if (key == 13)  // the enter key code
            {
                $('.js--searchFilterSubmit').click();
                return false;
            }
        });

        $('.dataTables_paginate').appendTo('.dashboardPage__pagination');
        $('.dataTables_empty, .dataTables_length, .dataTables_filter').remove(); // Select All Rows
      }
    });
  });

  $(function () {
    var table = $('#userDataList').DataTable({
      "paging": true,
      "pagingType": 'numbers',
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "pageLength": 20,
      "fixedHeader":!0,
      "scrollY":"530px",
      "scrollX": "100%",
      'searching': true,
      'processing': false,
      'serverSide': true,
      'ajax':{
        'url': $(".api_route").html(),
        'dataType': 'json',
        'type': 'GET',
        "dataSrc": function ( json ) {
          $('.dataListStatus__text').html("合計人数：" + json.totalPrice + "人");
          return json.data;
        }
      },
      'columns': [
        { 'data': 'os' },
        { 'data': 'user_name' },
        { 'data': 'purchase_num' },
        { 'data': 'sum_price' },
      ],
      'select': {
        'style': 'multi',
        'selector': '.dataList__inputSelect'
      },
      "columnDefs": [
        {'targets': 0, 'className': "dataList__itemDeviceName02"},
        {'targets': 2, 'className': "dataList__itemPurchaseNo02"},
        {'targets': 3, 'className': "dataList__itemPurchaseTotal02"},
        { 'searchable': false, 'targets': [0, 2, 3] },
        {
          'targets': 1,
          'searchable':true,
          'orderable':false,
          'className': 'dataList__itemBuyerName02',
          'render': function (data, type, full, meta){
            return '<a class="dataList__itemAnchor" href=./buyers/users/' + full.id + '>' + data + '</a>';
          }
        },
      ],

      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Japanese.json"
      },
      "initComplete": function(settings, json) {

        $('.js--searchFilterSubmit').on('click', function () {
          table.column(1).search($('.js--searchInputText').val()).draw();
        });

        $('.js--searchInputText').on("keydown", function (e) {
            var key = e.which;
            if (key == 13)  // the enter key code
            {
                $('.js--searchFilterSubmit').click();
                return false;
            }
        });

        $('.dataTables_paginate').appendTo('.dashboardPage__pagination');
        $('.dataTables_empty, .dataTables_length, .dataTables_filter').remove(); // Select All Rows
      }
    });
  });

  $(function(){
    if (location.pathname.match("buyers") == null){
      $("#nav_purchase_list").addClass('isActive');
      $("#nav_user_list").removeClass('isActive');
    }else{
      $("#nav_user_list").addClass('isActive');
      $("#nav_purchase_list").removeClass('isActive');
    };
  });
