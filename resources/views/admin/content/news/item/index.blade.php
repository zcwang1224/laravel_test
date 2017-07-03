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
            <h3>{{ trans('news.newsItemIndex_title') }}
            {{-- <small>Some examples to get you started</small> --}}
            </h3>
          </div>
          <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
              <div class="input-group">
              <form method="GET" action="{{ route('admin_news_item') }}">
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
            <form method="POST" action="{{ route('admin_news_item_multiple_action') }}" id="multiple_action_form">
              {{ csrf_field() }}
              <input type='hidden' name='checked_categories' id='checked_categories' value=''>
              <input type='hidden' name='multiple_action' id='multiple_action' value=''>
              <div class="x_title">
                <h2>{{ trans('news.newsItemIndex_item_list') }}
                {{-- <small>Custom design</small> --}}
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                      <li>
                          <a href="{{ route('admin_news_item_create') }}">{{ trans('default.default_create') }}</a>
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
                        <th class="column-title">{{ trans('news.newsItemIndex_item_title')}} </th>
                        <th class="column-title">{{ trans('news.newsItemIndex_item_category')}} </th>
                        <!-- <th class="column-title">Order </th>
                        <th class="column-title">Bill to Name </th>
                        <th class="column-title">Status </th>
                        <th class="column-title">Amount </th> -->
                        <th class="column-title no-link last"><span class="nobr">{{ trans('news.newsItemIndex_item_action') }}</span>
                        </th>
                        <th class="bulk-actions" colspan="7">
                          <a class="antoo" style="color:#fff; font-weight:500;">{{ trans('news.newsItemIndex_category_selected') }} ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($newsItems as $key => $newsItem)
          						<tr class="even pointer item_item" data-item_id="{{ $newsItem->news_item_id }}">
          							<td class="a-center ">
          							 	<input type="checkbox" class="flat" name="table_records">
          							</td>
          							
          							<td class=" ">{{ $newsItem->name }}</td>

          							<td class=" ">{{ $newsItem->newsCategory->name }}</td>
          							<!-- <td class=" ">121000210 <i class="success fa fa-long-arrow-up"></i></td>
          							<td class=" ">John Blank L</td>name
          							<td class=" ">Paid</td>
          							<td class="a-right a-right ">$7.45</td> -->
          							<td class="last">
		                      <div class="btn-group  btn-group-sm">
                              <input type="hidden" name="action" value="">
                              <button class="btn btn-info" type="button">
                                <a href="{{ route('admin_news_item_edit',['id'=>$newsItem->news_item_id]) }}">
                                  {{ trans('default.default_edit') }}
                                </a>
                              </button>                              
                              <button type="button" class="single_action btn @if($newsItem->deleted_at == null) btn-info @else btn-danger @endif" data-action="delete">
                                {{ trans('default.default_delete') }}
                              </button>
                              <button type="button" class="single_action btn @if($newsItem->status == 1) btn-info @else btn-danger @endif" data-action="@if($newsItem->status == 1) hide @else show @endif">
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
          {{ $newsItems->links() }}
           
        </div>
      </div>
    </div>
<script type="text/javascript">
    $(function(){
        /* multiple action  */
        $('.multiple_action').on('click',function(){
            var checked_str = getCheckedItem();
            var action      = $(this).data('action');
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

        /* single action */
        $('.single_action').on('click',function(){
            clearCheckedItem();
            var action = $(this).data('action');
            var checked_str = $(this).closest('tr').data('item_id');
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
    function getCheckedItem()
    {
        var checked_str = null;
        $('input[name="table_records"]:checked').each(function(){
            if(checked_str === null)
            {
                checked_str = $(this).closest('.item_item').data('item_id');
            }
            else
            {
                checked_str += ','+$(this).closest('.item_item').data('item_id');
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


</script>
@stop