{{-- 自動引入layouts.administration.blade.php 當為外層樣板 --}}
@extends('layouts.admin')

{{-- --------------- 最上方top -------------- --}}
@section('top')
	@parent
	@include('admin.partials.top')
@stop
{{-- --------------- 側邊選單 -------------- --}}
@section('sidebar')
	@parent
	@include('admin.partials.sidebar')
@stop
{{-- --------------- footer -------------- --}}
@section('footer')
	@parent
	@include('admin.partials.footer')
@stop
{{-- --------------- content -------------- --}}
@section('content')
	@parent
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>{{ trans('news.newsCategoryIndex_title') }} 
              {{-- <small>Some examples to get you started</small> --}}
            </h3>
          </div>
          <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
              <div class="input-group">
              <form method="GET" action="{{ route('admin_news_category') }}">
                <input type="text" name="search" class="form-control" placeholder="{{ trans('default.default_search') }}">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="submit">{{ trans('default.default_submit') }}</button>
                </span>                
              </form>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
            <form method="POST" action="{{ route('admin_news_category_multiple_action') }}" id="multiple_action_form">
              {{ csrf_field() }}
              <input type='hidden' name='checked_categories' id='checked_categories' value=''>
              <input type='hidden' name='multiple_action' id='multiple_action' value=''>
              <div class="x_title">
                <h2>{{ trans('news.newsCategoryIndex_category_list') }} 
                  {{-- <small>Custom design</small> --}}
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                      <li>
                          <a href="{{ route('admin_news_category_create') }}">{{ trans('default.default_create') }}</a>
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
                        <th class="column-title">{{ trans('news.newsCategoryIndex_category_title') }}</th>
                        <th class="column-title">{{ trans('news.newsCategoryIndex_category_create_date') }} </th>
                        <!-- <th class="column-title">Order </th>
                        <th class="column-title">Bill to Name </th>
                        <th class="column-title">Status </th>
                        <th class="column-title">Amount </th> -->
                        <th class="column-title no-link last">
                          <span class="nobr">
                            {{ trans('news.newsCategoryIndex_category_action') }}
                          </span>
                        </th>
                        <th class="bulk-actions" colspan="7">
                          <a class="antoo" style="color:#fff; font-weight:500;">{{ trans('news.newsCategoryIndex_category_selected') }} ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($newsCategories as $key => $newsCategory)
          						<tr class="even pointer category_item" data-category_id="{{ $newsCategory->news_category_id }}">
          							<td class="a-center ">
          							 	<input type="checkbox" class="flat" name="table_records">
          							</td>
          							
          							<td class=" ">{{ $newsCategory->name }}</td>

          							<td class=" ">{{ $newsCategory->created_at }}</td>
          							<!-- <td class=" ">121000210 <i class="success fa fa-long-arrow-up"></i></td>
          							<td class=" ">John Blank L</td>
          							<td class=" ">Paid</td>
          							<td class="a-right a-right ">$7.45</td> -->
          							<td class="last">
		                      <div class="btn-group  btn-group-sm">
		                        <button class="btn btn-info" type="button">
                              <a href="{{ route('admin_news_category_edit',['id'=>$newsCategory->news_category_id]) }}">
                                {{ trans('default.default_edit') }}
                              </a>
                            </button>
                            <button class="single_action btn @if($newsCategory->deleted_at == null) btn-info @else btn-danger @endif" type="button" data-action='delete'>
                              {{ trans('default.default_delete') }}
                            </button>
		                        <button class="single_action btn @if($newsCategory->status == 1) btn-info @else btn-danger @endif" type="button" data-action="@if($newsCategory->status == 1) hide @else show @endif">
                              {{ trans('default.default_hide') }}
                            </button>
		                      </div>							
          							</td>
          						</tr>
          					@endforeach	

                    </tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>
          {{ $newsCategories->links() }}
           
        </div>
      </div>
    </div>
<script type="text/javascript">
    $(function(){
        /* multiple action  */
        $('.multiple_action').on('click',function(){
            var checked_str = getCheckedCategory();
            var action      = $(this).data('action');
            var url         = "{{ route('admin_news_ajax_category_related_item') }}";
            $('#checked_categories').val(checked_str); // form
            $('#multiple_action').val(action);         // form
            var check_related_item = checkRelatedItem(checked_str,url);
            var sum_item = 0;     // 計算全部category一共被多少個item關聯
            $.each(check_related_item,function(i,v){
                sum_item += v.count;
            });

            if(sum_item >0 && action == 'delete')
            {
                swal({
                  title: '{{ trans("default.default_confirm_edit") }}',
                  // text: "You won't be able to revert this!",
                  type: 'question',
                  animation : true,
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'delete all items',
                  cancelButtonText: '{{ trans("default.default_cancel") }}',
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false
                }).then(function () {
                  $('#multiple_action_form').submit();
                });                             
            }
            else //有item，如果要刪除，要連item一起刪除。
            {
                swal({
                  title: '{{ trans("default.default_confirm_edit") }}',
                  // text: "You won't be able to revert this!",
                  type: 'question',
                  animation : true,
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: '{{ trans("default.default_yes") }}',
                  cancelButtonText: '{{ trans("default.default_no") }}',
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false
                }).then(function () {
                  $('#multiple_action_form').submit();
                });              
            }
           
        });
        /* single action */
        $('.single_action').on('click',function(){
              clearCheckedItem();
              var action = $(this).data('action');
              var checked_str = $(this).closest('tr').data('category_id');
              $('#checked_categories').val(checked_str);
              $('#multiple_action').val(action);
            swal({
              title: '{{ trans("default.default_confirm_edit") }}',
              // text: "You won't be able to revert this!",
              type: 'question',
              animation : true,
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: '{{ trans("default.default_yes") }}',
              cancelButtonText: '{{ trans("default.default_no") }}',
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false,
            }).then(function () {
              $('#multiple_action_form').submit(); 
            });          
           
        });        
    });
    /** --------------------
     *  抓取勾選的Category id
     */
    function getCheckedCategory()
    {
        var checked_str = null;
        $('input[name="table_records"]:checked').each(function(){
            if(checked_str === null)
            {
                checked_str = $(this).closest('.category_item').data('category_id');
            }
            else
            {
                checked_str += ','+$(this).closest('.category_item').data('category_id');
            }
        }); 
        return checked_str;  
    }
    /** --------------------
     *  清除勾選的Category id
     */
    function clearCheckedItem()
    {
        $('input[name="table_records"]:checked').each(function(){
            $(this).attr('checked',false);
            $(this).closest('div').removeClass('checked');
            $(this).closest('tr').removeClass('selected');
            $(this).closest('#headings').removeClass('selected');
        });         
    }  
    /** --------------------
     *  檢查關聯到Item的數量
     */
    function checkRelatedItem(/*String*/ ids,url)
    {
      var result = null;
      $.ajax({
        url       : url,
        type      : 'GET',
        dataType  : 'json',
        data      : 'ids='+ids,
        async     : false,
        success   : function(data){
          result = data;
        } 
      });
      return result;
    }
</script>
@stop