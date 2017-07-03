<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>
    <!-- jQuery -->
    <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
  
    <!-- bootstrap-progressbar -->
    <link href="{{ asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- Switchery -->
    <link href="{{ asset('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="{{ asset('vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet"/>
    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
    <!-- SweetAlert 2 Style -->
    <link rel="stylesheet" href="{{ asset('sweetalert2-master/dist/sweetalert2.min.css') }}">      
    <!-- PNotify -->
<!--     <link href="{{ asset('vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">   -->    
  </head>

  <body class="nav-md">
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>{{ trans_choice('product.product_title',2,['type1' => trans('default.default_item'),
                                                           'type2' => trans('default.default_list')]) }}
            </h3>
          </div>
          <div class="title_right">
            <form method="GET" action="{{ route('admin_product_item_popup') }}">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                  <input type="text" name="search" class="form-control" placeholder="{{ trans('default.default_search') }}">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">{{ trans('default.default_submit') }}</button>
                  </span>       
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
            <form method="POST" action="{{ route('admin_product_item_multiple_action') }}" id="multiple_action_form">
              {{ csrf_field() }}
              <input type='hidden' name='checked_categories' id='checked_categories' value=''>
              <input type='hidden' name='multiple_action' id='multiple_action' value=''>
              <div class="x_title">
                <h2>
                  {{ trans('product.productItemIndex_item_list') }}
                </h2>
              {{--  
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                      <li>
                          <a href="{{ route('admin_product_item_create') }}">{{ trans('default.default_create') }}</a>
                      </li>
                      <li>
                          <a href="#" class="multiple_action" data-action='delete'>{{ trans('default.default_delete') }}</a>
                      </li>
                      <li>
                          <a href="#" class="multiple_action" data-action='hide'>{{ trans('default.default_hide') }}</a>
                      </li>
                      <li>
                          <a href="#" class="multiple_action" data-action='show'>{{ trans('default.default_show') }}</a>
                      </li>                                            
                    </ul>
                  </li>
                </ul>
              --}}
                <div class="clearfix"></div>
              </div>
            </form>
              <div class="x_content">
                <div class="table-responsive">
                  <table class="table table-striped jambo_table bulk_action">
                    <thead>
                      <tr class="headings" id="headings">
                        <th>
                          <input type="checkbox" id="check-all" class="flat">
                        </th>
                        <th class="column-title">{{ trans('product.productItem_item_image')}} </th>
                        <th class="column-title">{{ trans('product.productItemIndex_item_title')}} </th>
                        <th class="column-title">{{ trans('product.productItemIndex_item_category')}} </th>
                        <th class="column-title">{{ trans('product.productItemIndex_item_create_date')}} </th>
                        <th class="bulk-actions" colspan="7">
                          <a class="antoo" style="color:#fff; font-weight:500;">
                            {{ trans('default.default_checked') }} 
                            ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i>
                          </a>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($productItems as $key => $productItem)
                      <tr class="even pointer item_item" data-item_id="{{ $productItem->product_item_id }}" data-item_image="{{ $productItem->image }}" data-item_name="{{ $productItem->name }}" data-item_category_name="{{ $productItem->productCategory->name }}" data-item_create_at="{{ $productItem->created_at }}">
                        <td class="a-center ">
                          <input type="checkbox" class="flat" name="table_records">
                        </td>
                        <td><img src="{{ $productItem->image }}" width="50px" height="50px"></td>
                        <td>{{ $productItem->name }}</td>
                        <td>{{ $productItem->productCategory->name }}</td>
                        <td>{{ $productItem->created_at }}</td>
                      {{-- 
                        <td class="last">
                          <div class="btn-group  btn-group-sm">
                              <input type="hidden" name="action" value="">
                              <button class="btn btn-info" type="button">
                                <a href="{{ route('admin_product_item_edit',['id'=>$productItem->product_item_id]) }}">
                                  {{ trans('default.default_edit') }}
                                </a>
                              </button>                              
                              <button type="button" class="single_action btn @if($productItem->deleted_at == null) btn-info @else btn-danger @endif" data-action="delete">
                                {{ trans('default.default_delete') }}
                              </button>
                              <button type="button" class="single_action btn @if($productItem->status == 1) btn-info @else btn-danger @endif" data-action="@if($productItem->status == 1) hide @else show @endif">
                                {{ trans('default.default_hide') }}
                              </button>
                          </div>              
                        </td>
                      --}}
                      </tr>
                    @endforeach 

                    </tbody>

                  </table>
                  <button id="button" class="btn-round btn-primary">submit</button>
                </div>
              </div>
            </div>
          </div>

          {{ $productItems->links() }}
        </div>
      </div>
    </div>
<script type="text/javascript">
    $(function(){
        $( "#button" ).click(function() {
          //傳值給原視窗 
          var item_ids = getCheckedItem();
          $('#popup_container', window.parent.document).val(item_ids);
          parent.$.fn.colorbox.close();//關閉視窗
        });      
    });
    /** --------------------
     *  抓取勾選的Item id
     */
    function getCheckedItem()
    {
        var checked_arr = [];
        $('input[name="table_records"]:checked').each(function(i,v){
            var temp_obj = {};
            temp_obj['item_id']            = $(this).closest('.item_item').data('item_id');
            temp_obj['item_image']         = $(this).closest('.item_item').data('item_image');
            temp_obj['item_name']          = $(this).closest('.item_item').data('item_name');
            temp_obj['item_category_name'] = $(this).closest('.item_item').data('item_category_name');
            temp_obj['item_create_at']     = $(this).closest('.item_item').data('item_create_at');
            checked_arr[i] = temp_obj;
        }); 
        return JSON.stringify(checked_arr);  
    }    
</script>


    <!-- Bootstrap -->
    <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
    <!-- Chart.js -->
    <script src="{{ asset('vendors/Chart.js/dist/Chart.min.js') }}"></script>
    <!-- gauge.js -->
    <script src="{{ asset('vendors/gauge.js/dist/gauge.min.js') }}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('vendors/iCheck/icheck.min.js') }}"></script>
    <!-- Skycons -->
    <script src="{{ asset('vendors/skycons/skycons.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.resize.js') }}"></script>
    <!-- Flot plugins -->
    <script src="{{ asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('vendors/flot.curvedlines/curvedLines.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('vendors/DateJS/build/date.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script src="{{ asset('vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset('vendors/switchery/dist/switchery.min.js') }}"></script>
    <!-- jQuery custom content scroller -->
    <script src="{{ asset('vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>    
    <!-- SweetAlert 2 Scripts -->
    <script src="{{ asset('sweetalert2-master/dist/sweetalert2.min.js') }}"></script>

    <!-- PNotify -->
<!--     <script src="{{ asset('vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>   -->  
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('build/js/custom.min.js') }}"></script>

  </body>
</html>