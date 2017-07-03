{{-- 自動引入layouts.administration.blade.php 當為外層樣板 --}}
@extends('layouts.admin')

{{-- --------------- 最上方top -------------- --}}
@section('top')
    @parent
    <!-- CSS -->
    <link href="{{ asset('vendors/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">  <!-- DropZone -->
    <link rel="stylesheet" href="{{ asset('colorbox-master/colorbox.css') }}" />  <!-- ColorBox -->
    <!-- JS -->
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>   <!-- CKEditor -->
    <script src="{{ asset('vendors/dropzone/dist/min/dropzone.min.js') }}"></script>  <!-- DropZone -->
    <script src="{{ asset('colorbox-master/jquery.colorbox.js') }}"></script>   <!-- ColorBox -->
    <script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}"></script>

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
        <div class="right_col" role="main" id="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>
                  {{ trans_choice('product.product_title',2,['type1' => trans('default.default_item'),
                                                               'type2' => trans('default.default_edit')]) }}
                </h3>
              </div>
            </div>
            <form method="POST" action="{{ route('admin_product_item_edit',['id' => $productItem->product_item_id]) }}" id="main_form" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
              {{ csrf_field() }}            
              <div class="clearfix"></div>
          {{-- --------- Validation Error 表單驗證錯誤訊息------------ --}}
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif                 
          {{-- ------------------ 基本 設定------------------ --}}             
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>
                        @lang('default.default_basic_setting')
                      </h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                  {{-- Item 分類 --}}    
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('product.productItem_item_category') }}</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" name="product_category_id">
                            <option value="{{ $productItem->product_item_id }}"></option>
                          @foreach($productCategories as $key => $value)
                            <option value="{{ $value->product_category_id }}" @if($productItem->product_category_id == $value->product_category_id) selected @endif>{{ $value->name }}</option>
                          @endforeach               
                          </select>
                        </div>
                      </div>                     
                      <br />                       
                  {{-- Name 標題 --}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">{{ trans('product.productItem_item_title') }}
                         <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="name" id="name" value="{{ $productItem->name }}" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
                      <br /> 
                  {{-- 商品 描述 1 --}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description1">{{ trans('product.productItem_item_description1') }}
                         <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea name="description1" id="description1" class="form-control col-md-7 col-xs-12">{{ $productItem->description1 }}</textarea>
                        </div>
                      </div> 
                      <br /> 
                  {{-- 商品 描述 2 --}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description2">{{ trans('product.productItem_item_description2') }}
                         <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea name="description2" id="description2" class="form-control col-md-7 col-xs-12">{{ $productItem->description2 }}</textarea>
                        </div>
                      </div> 
                      <br />                       
                  {{-- Image Upload 圖片上傳 --}}     
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> {{ trans('product.productItem_item_image') }}
                         <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="input-group">
                             <span class="input-group-btn">
                               <a id="image" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                 <i class="fa fa-picture-o"></i> {{ trans('default.default_choose') }}
                               </a>
                             </span>
                             <input id="thumbnail" class="form-control" type="text" name="image" value="{{ $productItem->image }}" readonly>
                           </div>
                           <img id="holder" style="margin-top:15px;max-height:100px;" src="{{ $productItem->image }}">                  
                        </div>
                      </div> 
                      <br />      
                  {{-- Status 分類狀態 --}}                                          
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('product.productItem_item_status') }}
                         <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label>
                            <input type="checkbox" name="status" class="js-switch" value="1" @if($productItem->status ==1) checked @endif/> {{ trans('default.default_checked') }}
                          </label>
                        </div> 
                      </div>  
                    </div>               
                  </div>
                </div>
              </div>

              
              {{-- ------------------ CKEditor 設定------------------ --}}  
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>{{ trans('product.productItem_item_content')}}</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="display: none;">
                      <br />
                    {{-- CKEditor with Responsive FileSystem --}}
                      <textarea id="content1" name="content1" class="form-control">{{ $productItem->content1 or '' }}</textarea>
                      <script>
                        var options = {
                          filebrowserImageBrowseUrl: '{{ route("filemanager"        , ["type" => "Images"]) }}',
                          filebrowserImageUploadUrl: '{{ route("filemanager_upload" , ["type" => "Images", "_token"]) }}',
                          filebrowserBrowseUrl:      '{{ route("filemanager"        , ["type" => "Files"]) }}',
                          filebrowserUploadUrl:      '{{ route("filemanager_upload" , ["type" => "Files", "_token"]) }}'
                        };
                      </script>
                      <script>
                      CKEDITOR.replace('content1', options);
                      </script>                       
                    </div>
                  </div>
                </div>
              </div>
              {{-- ------------------ CKEditor 設定 - content2 ------------------ --}}  
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>{{ trans('product.productItem_item_content') }}</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="display: none;">
                      <br />
                    {{-- CKEditor with Responsive FileSystem --}}
                      <textarea id="content2" name="content2" class="form-control">{{ $productItem->content2 or '' }}</textarea>
                      <script>
                        var options = {
                          filebrowserImageBrowseUrl: '{{ route("filemanager"        , ["type" => "Images"]) }}',
                          filebrowserImageUploadUrl: '{{ route("filemanager_upload" , ["type" => "Images", "_token"]) }}',
                          filebrowserBrowseUrl:      '{{ route("filemanager"        , ["type" => "Files"]) }}',
                          filebrowserUploadUrl:      '{{ route("filemanager_upload" , ["type" => "Files", "_token"]) }}'
                        };
                        CKEDITOR.replace('content2', options);
                      </script>  
                    </div>
                  </div>
                </div>
              </div>  
              {{-- ------------------ CKEditor 設定 - content3 ------------------ --}}  
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>{{ trans('product.productItem_item_content') }}</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="display: none;">
                      <br />
                    {{-- CKEditor with Responsive FileSystem --}}
                      <textarea id="content3" name="content3" class="form-control">{{ $productItem->content3 or '' }}</textarea>
                      <script>
                        var options = {
                          filebrowserImageBrowseUrl: '{{ route("filemanager"        , ["type" => "Images"]) }}',
                          filebrowserImageUploadUrl: '{{ route("filemanager_upload" , ["type" => "Images", "_token"]) }}',
                          filebrowserBrowseUrl:      '{{ route("filemanager"        , ["type" => "Files"]) }}',
                          filebrowserUploadUrl:      '{{ route("filemanager_upload" , ["type" => "Files", "_token"]) }}'
                        };
                        CKEDITOR.replace('content3', options);
                      </script>  
                    </div>
                  </div>
                </div>
              </div>  
              {{-- ------------------ CKEditor 設定 - content4 ------------------ --}}  
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>{{ trans('product.productItem_item_content') }}</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="display: none;">
                      <br />
                    {{-- CKEditor with Responsive FileSystem --}}
                      <textarea id="content4" name="content4" class="form-control">{{ $productItem->content4 or '' }}</textarea>
                      <script>
                        var options = {
                          filebrowserImageBrowseUrl: '{{ route("filemanager"        , ["type" => "Images"]) }}',
                          filebrowserImageUploadUrl: '{{ route("filemanager_upload" , ["type" => "Images", "_token"]) }}',
                          filebrowserBrowseUrl:      '{{ route("filemanager"        , ["type" => "Files"]) }}',
                          filebrowserUploadUrl:      '{{ route("filemanager_upload" , ["type" => "Files", "_token"]) }}'
                        };
                        CKEDITOR.replace('content4', options);
                      </script>   
                    </div>
                  </div>
                </div>
              </div>                
              {{-- ------------------ SEO 設定------------------ --}}             
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>{{ trans('product.productItem_item_seo_setting') }}</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="display: none;">
                      <br />
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="seo_title">
                          {{ trans('product.productItem_item_seo_title') }}
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="seo_title" id="seo_title" value="{{ $productItem->seo_title }}" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="seo_description">
                          {{ trans('product.productItem_item_seo_description') }}
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="seo_description" id="seo_description" value="{{ $productItem->seo_description }}" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="seo_keyword">
                          {{ trans('product.productItem_item_seo_keyword') }}
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="seo_keyword" id="seo_keyword" value="{{ $productItem->seo_keyword }}" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>
              {{-- ------------------ 產品規格 設定------------------ --}}             
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>{{ trans('product.productItem_item_stand_title') }}</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="display: none;">
                      <br />
                      <div class="btn-toolbar">   
                        <button type="button" id="create_stand_template_btn" class="btn btn-default" aria-label="Left Align">
                          <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                        </button>
                      </div>    
                      <br />
                      {{-- 規格設定 --}}
                      <div id="stand_container">
                        <div class="control-group stand_item_container">
                          <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12">Input Tags</label> -->
                          <div class="col-md-3 col-sm-4 col-xs-4">
                            <input type="text" name="stand_name[]" class="form-control" placeholder="{{ trans('default.default_please_input',['type' => trans('product.productItem_item_stand_name')]) }}">
                          </div>
                          <div class="col-md-8  col-sm-4 col-xs-4">
                            <input id="stand_1" name="stand[]" type="text" class="tags form-control" />
                            <div style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                          </div>
                          <div class="col-md-1 col-sm-4 col-xs-4">
                            <button type="button" class="btn btn-default btn-danger stand_remove_btn" aria-label="Left Align">
                              <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                            </button> 
                          </div>                           
                        </div> 
                        <div class="control-group stand_item_container" >
                          <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12">Input Tags</label> -->
                          <div class="col-md-3 col-sm-6 col-xs-6">
                            <input type="text" name="stand_name[]" class="form-control" placeholder="{{ trans('default.default_please_input',['type' => trans('product.productItem_item_stand_name')]) }}">
                          </div>                          
                          <div class="col-md-8 col-sm-6 col-xs-12">
                            <input id="stand_2" name="stand[]" type="text" class="tags form-control" />
                            <div style="position: relative; float: left; width: 25px; margin: 10px;"></div>
                          </div>
                          <div class="col-md-1 col-sm-6 col-xs-12">
                            <button type="button" class="btn btn-default btn-danger stand_remove_btn" aria-label="Left Align">
                              <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                            </button> 
                          </div>                          
                        </div> 
                      </div>   

  <table class="table table-striped jambo_table bulk_action">
    {{-- 表格標題 --}}
    <thead>
      <tr class="headings">
        <th><input type="checkbox" id="check-all" class="flat" data-checkbox_name="product_stand_table"></th>
        <div id="product_stand_item_head_container">
        <!-- <th class="column-title">{{ trans('product.productItem_item_stand_name')}} </th> -->
        </div>
        <th class="column-title">{{ trans('product.productItemIndex_item_title')}} </th>
        <th class="column-title last">{{ trans('product.productItemIndex_item_category')}} </th>
        <th class="bulk-actions" colspan="3">
          <a class="antoo" style="color:#fff; font-weight:500;">
          {{ trans('default.default_checked') }}  ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
        </th>
      </tr>
    </thead> 
    {{-- 表格內容 --}}
    <tbody id="product_stand_item_container"> 
<!--     @foreach($productItem->productItemImages as $key => $value)   
      <tr class="even pointer" data-item_id="{{ $value->product_item_id }}">
        <td class="a-center ">
          <input type="checkbox" class="flat" name="image_table" data-checkbox_name="image_table" >
        </td>
        <td><input type="text" name="multiple_image_comment[]" value="{{ $value->image_comment }}" class="form-control col-md-7 col-xs-12"></td>
        <td>        
          <div class="col-md-10 col-sm-6 col-xs-12">
             <div class="input-group">
               <input id="thumbnail_{{$key}}" class="form-control" data-checkbox_name="image_table" type="text" name="multiple_image[]" value="{{ $value->image_path }}" readonly>
               <span class="input-group-btn">
                 <a id="image_tr_{{$key}}" data-input="thumbnail_{{$key}}" data-preview="image_holder_{{$key}}" class="btn btn-primary">
                   <i class="fa fa-picture-o"></i> {{ trans('default.default_choose') }}
                 </a>
               </span>             
             </div>          
          </div>
        </td>   
        <td><img id="image_holder_{{$key}}" style="max-height:100px;" width="50px" height="50px" src="{{ $value->image_path }}"></td>
        </td>
      </tr>
    @endforeach   -->
    </tbody>
  </table> 


                    </div>
                  </div>
                </div>
              </div>
              {{-- ------------------ 無限上圖 設定 - 商品圖片 ------------------ --}}  
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>{{ trans('product.productItem_item_upload_image') }}</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="display: none;">
                      <br />
                      <div class="btn-toolbar">   
                        <button type="button" id="create_image_template_btn" class="btn btn-default" aria-label="Left Align">
                          <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                        </button> 
                        <button type="button" id="delete_image_btn" class="btn btn-default btn-danger" aria-label="Left Align">
                          <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                        </button>
                      </div>                         
                      <table class="table table-striped jambo_table bulk_action">
                        {{-- 表格標題 --}}
                        <thead>
                          <tr class="headings">
                            <th><input type="checkbox" id="check-all" class="flat" data-checkbox_name="image_table"></th>
                            <th class="column-title">{{ trans('product.productItem_item_image')}} </th>
                            <th class="column-title">{{ trans('product.productItemIndex_item_title')}} </th>
                            <th class="column-title last">{{ trans('product.productItemIndex_item_category')}} </th>
                            <th class="bulk-actions" colspan="3">
                              <a class="antoo" style="color:#fff; font-weight:500;">
                              {{ trans('default.default_checked') }}  ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead> 
                        {{-- 表格內容 --}}
                        <tbody id="image_item_container"> 
                        @foreach($productItem->productItemImages as $key => $value)   
                          <tr class="even pointer" data-item_id="{{ $value->product_item_id }}">
                            <td class="a-center ">
                              <input type="checkbox" class="flat" name="image_table" data-checkbox_name="image_table" >
                            </td>
                            <td><input type="text" name="multiple_image_comment[]" value="{{ $value->image_comment }}" class="form-control col-md-7 col-xs-12"></td>
                            <td>        
                              <div class="col-md-10 col-sm-6 col-xs-12">
                                 <div class="input-group">
                                   <input id="thumbnail_{{$key}}" class="form-control" data-checkbox_name="image_table" type="text" name="multiple_image[]" value="{{ $value->image_path }}" readonly>
                                   <span class="input-group-btn">
                                     <a id="image_tr_{{$key}}" data-input="thumbnail_{{$key}}" data-preview="image_holder_{{$key}}" class="btn btn-primary">
                                       <i class="fa fa-picture-o"></i> {{ trans('default.default_choose') }}
                                     </a>
                                   </span>             
                                 </div>          
                              </div>
                            </td>   
                            <td><img id="image_holder_{{$key}}" style="max-height:100px;" width="50px" height="50px" src="{{ $value->image_path }}"></td>
                            </td>
                          </tr>
                        @endforeach  
                        </tbody>
                      </table>                          
                      </div>
                    </div>
                  </div>
                </div>
              </div>                 
              {{-- ------------------ 相關商品 設定------------------ --}}             
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>{{ trans('product.productItem_item_relative_setting') }}</h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                          <ul class="dropdown-menu" role="menu">
                          {{-- 新增 --}}
                            <li><a href="javascript:void(0);" id="color_relative_item">{{ trans('default.default_create') }}</a></li>
                          {{-- 刪除 --}}
                            <li><a href="javascript:void(0);" id="delete_related_item_btn">{{ trans('default.default_delete') }}</a></li>
                          </ul>
                        </li>                        
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="display: none;">
                    {{-- 存放related colorbox回傳回來的item id --}}
                      <input type="hidden" value="" id="popup_container">
                    {{-- 傳遞到controller的form表單欄位 --}}
                      <input type="hidden" name="related_items" id="related_item_container">
                      <br />                  
                      <table class="table table-striped jambo_table bulk_action">
                        {{-- 表格標題 --}}
                        <thead>
                          <tr class="headings">
                            <th><input type="checkbox" id="check-all" class="flat"></th>
                            <th class="column-title">{{ trans('product.productItem_item_image')}} </th>
                            <th class="column-title">{{ trans('product.productItemIndex_item_title')}} </th>
                            <th class="column-title">{{ trans('product.productItemIndex_item_category')}} </th>
                            <th class="column-title">{{ trans('product.productItemIndex_item_create_date')}} </th>
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">{{ trans('default.default_checked') }}  ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead> 
                        {{-- 表格內容 --}}
                        <tbody id="relative_item_container">    
                        @foreach($productItem->itemHasRelated as $key => $value)
                          <tr class="even pointer" data-item_id="{{ $value->product_item_id }}">
                            <td class="a-center ">
                              <input type="checkbox" class="flat" name="table_records">
                            </td>
                            <td><img width="50px" height="50px" src="{{ $value->image }}"></td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->productCategory->name }}</td>
                            <td>{{ $value->created_at }}</td>
                            </td>
                          </tr>
                        @endforeach                    
                        </tbody>
                      </table>                      
                    </div>
                  </div>
                </div>
              </div>              
              {{-- ------------------ 送出按鈕 ------------------ --}}
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="button" class="btn btn-primary" id="cancel_btn">{{ trans('default.default_cancel') }}</button>
                        <button type="button" class="btn btn-primary" id="reset_btn">{{ trans('default.default_reset') }}</button>
                        <button type="button" class="btn btn-success" id="submit_btn">{{ trans('default.default_submit') }}</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div> 
            </form> 

          </div>
        </div> 
    <!-- Jquery Template - stand template -->
    <script type="text/html" id="stand_template">
      <div class="control-group stand_item_container">
        <!-- <label class="control-label col-md-3 col-sm-3 col-xs-12">Input Tags</label> -->
        <div class="col-md-3 col-sm-6 col-xs-6">
          <input type="text" name="stand_name[]" class="form-control" data-id="stand_name_input" placeholder="{{ trans('default.default_please_input',['type' => trans('product.productItem_item_stand_name')]) }}">
        </div>        
        <div class="col-md-8 col-sm-6 col-xs-12">
          <input data-id="stand_id" name="stand[]" type="text" class="tags form-control" />
          <div style="position: relative; float: left; width: 250px; margin: 10px;"></div>
        </div>
        <div class="col-md-1 col-sm-6 col-xs-12">
          <button type="button" class="btn btn-default btn-danger stand_remove_btn" aria-label="Left Align">
            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
          </button> 
        </div>          
      </div>  
    </script>           
    <!-- Jquery Template - image item -->
    <script type="text/html" id="image_template">
        <tr class="even pointer">
          <td class="a-center ">
            <input type="checkbox" class="flat" name="image_table" data-checkbox_name="image_table">
          </td>
          <td><input type="text" value="" name="multiple_image_comment[]" class="form-control col-md-7 col-xs-12" ></td>
          <td>        
            <div class="col-md-10 col-sm-6 col-xs-12">
               <div class="input-group">
                 <input data-id="thumbnail" class="form-control"  type="text" name="multiple_image[]" readonly>
                 <span class="input-group-btn">
                   <a data-id="lfm" data-template-bind='[{"attribute": "data-input", "value": "thumbnail"},{"attribute": "data-preview", "value": "holder"}]' class="btn btn-primary">
                     <i class="fa fa-picture-o"></i> {{ trans('default.default_choose') }}
                   </a>
                 </span>             
               </div>          
            </div>
          </td>   
          <td><img data-id="holder" style="max-height:100px;" width="50px" height="50px"></td>
          </td>
        </tr>  
    </script>         
    <!-- Jquery Template - related product item -->
    <script type="text/html" id="related_template">
      <tr class="even pointer" data-template-bind='[{"attribute": "data-item_id", "value": "item_id"}]'>
        <td class="a-center ">
          <input type="checkbox" class="flat" name="table_records">
        </td>
        <td class=" "><img width="50px" height="50px" data-src="item_image"></td>
        <td data-content="item_name"></td>
        <td data-content="item_category_name"><i class="success fa fa-long-arrow-up"></i></td>
        <td data-content="item_create_at"></td>
        </td>
      </tr>
    </script>             
    <script>
      $(document).ready(function(){


        /* --------- initialize tagsInput plugin -----------*/ 
        var init_stand_length = $('#stand_container > div').length;
        for(var i = 1 ; i <= init_stand_length ;i++)
        {
            var stand_id    = 'stand_'+i;
            $("#"+stand_id).tagsInput({
                                      width       : "auto",
                                      defaultText : "{{ trans('product.productItem_item_stand_create') }}",
                                      height      : '100px',
                                      width       : '600px',
                                      removeText  : "{{ trans('product.productItem_item_stand_remove') }}",                                    
                                  });
        }
        bind_remove_stand();
        /* --------- initialize filemanager plugin -----------*/ 
        var init_items_length = $('#image_item_container > tr').length;
        for(var i = 0 ; i < init_items_length ;i++)
        {
          $('#image_tr_'+i).filemanager('image');
        }
        saveRelatedItems(); // related_item 存到 #related_item_container 內
        $('#image').filemanager('image');
       

        /* --------- Jquery template - create new stand item -----------*/ 
        $('#create_stand_template_btn').on('click', function(){
            var count_items         = $('#stand_container > div').length+1;
            var stand_id            = 'stand_'+count_items;
            var stand_name_input_id = 'stand_name_input_'+count_items;
            var options             = {
                                        'stand_id'         : stand_id,
                                        'stand_name_input' : stand_name_input_id,
                                      };
            $('#stand_container').loadTemplate("#stand_template",options,{append:true});                              
            $("#"+stand_id).tagsInput({
                                      width       : "auto",
                                      defaultText : "{{ trans('product.productItem_item_stand_create') }}",
                                      height      : '100px',
                                      width       : '600px',   
                                      removeText  : "{{ trans('product.productItem_item_stand_remove') }}",                                    
                                  });
            bing_change_stand_name(stand_name_input_id);
            bind_remove_stand();
        });       
        /* --------- Jquery template - create new image item -----------*/ 
        $('#create_image_template_btn').on('click', function(){
            var count_items = $('#image_item_container > tr').length+1;
            var options     = {
                                'thumbnail' :'thumbnail_'+count_items,
                                'holder'    :'image_holder_'+count_items,
                                'lfm'       :'image_tr_'+count_items
                              };
            $('#image_item_container').loadTemplate("#image_template",options,{append:true});
            initialChecked(); 
            $('#image_tr_'+count_items).filemanager('image');
        });

        /* -------- Jquery template - related item ----------*/  
        $('#color_relative_item').on('click', function(){
            
            var url = "{{ route('admin_product_item_popup')}}?ids="+fetchRelatedItems()+"&current_id={{ $productItem->product_item_id }}";
            $.colorbox({
                          iframe:true, 
                          fixed:true, 
                          width:"80%", 
                          height:"80%",
                          href:url,
                          onClosed:function()
                          {
                              var item_ids = $("#popup_container").val();
                              $("#popup_container").val('');
                              $("#relative_item_container").loadTemplate("#related_template",JSON.parse(item_ids),{append:true});
                              initialChecked(); 
                              saveRelatedItems();                                                              
                          }
                        });
        }); 

        /* -------- 刪除圖片 ----------*/
        $('#delete_image_btn').on('click', function(){
            $('#image_item_container .icheckbox_flat-green').each(function(i,v){
                if($(this).hasClass('checked')){
                  $(this).closest('tr').remove();
                }
            });  
            $('#check-all').trigger('ifUnchecked');
        });
        /* -------- 刪除相關產品 ----------*/
        $('#delete_related_item_btn').on('click',function(){
            $('#relative_item_container .icheckbox_flat-green').each(function(i,v){
                if($(this).hasClass('checked')){
                  $(this).closest('tr').remove();
                }
            });
            saveRelatedItems();
        });


          /* -------- SweetAlert 2 - Submit Confirm ----------*/
              $('#submit_btn').on('click',function(){

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
                  $('#main_form').submit();
                });                 
                
              });
          /* -------- SweetAlert 2 - Reset Confirm ----------*/
              $('#reset_btn').on('click',function(){

                swal({
                  title: '{{ trans("default.default_confirm_reset") }}',
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
                  $('#main_form').reset();
                });                 
                
              });

      });
      
      /* -------- bind - 刪除規格 ----------*/
      function bind_remove_stand()
      {
        $('.stand_remove_btn').unbind();
        $('.stand_remove_btn').on('click', function(){
            $(this).closest('.stand_item_container').remove();
        });        
      }
      /* -------- bind - 改變規格名稱 ----------*/
      function bing_change_stand_name(stand_name_input_id)
      {
        $('#'+stand_name_input_id).unbind();
        $('#'+stand_name_input_id).on('change', function(){
            alert("123");
        });           
      }      
      
      /* ---------------------------------------------------
       * 回傳表格內所有關連項目的 id
       * @param  
       * @return String
       * ---------------------------------------------------*/
        function fetchRelatedItems()
        {
            var items = ''
            $('#relative_item_container > tr').each(function(i,v){
                if(items == '')
                {
                    items += $(this).data('item_id');
                }
                else
                {
                    items += ','+$(this).data('item_id');
                }
            });
            return items;
        }       
      /* ---------------------------------------------------
       * 將表格內的關連項目儲存到 #related_item_container 中
       * @param  
       * @return 
       * ---------------------------------------------------*/
        function saveRelatedItems()
        {
            var items = fetchRelatedItems();
            $('#related_item_container').val(items);
        }
      /* ---------------------------------------------------
       * bind iCheck 
       * @param  
       * @return 
       * ---------------------------------------------------*/        
        function initialChecked()
        {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
            $('table input').on('ifChecked', function () {
                checkState = '';
                $(this).parent().parent().parent().addClass('selected');
                var input_name = $(this).data('checkbox_name');
                countChecked();
            });
            $('table input').on('ifUnchecked', function () {
                checkState = '';
                $(this).parent().parent().parent().removeClass('selected');
                var input_name = $(this).data('checkbox_name');
                countChecked(input_name);
            });

            $('.bulk_action input').on('ifChecked', function () {
                checkState = '';
                $(this).parent().parent().parent().addClass('selected');
                var input_name = $(this).data('checkbox_name');
                countChecked(input_name);
            });
            $('.bulk_action input').on('ifUnchecked', function () {
                checkState = '';
                $(this).parent().parent().parent().removeClass('selected');
                var input_name = $(this).data('checkbox_name');
                countChecked(input_name);
            });
            $('.bulk_action input#check-all').on('ifChecked', function () {
                checkState = 'all';
                var input_name = $(this).data('checkbox_name');
                countChecked(input_name);
            });
            $('.bulk_action input#check-all').on('ifUnchecked', function () {
                checkState = 'none';
                var input_name = $(this).data('checkbox_name');
                countChecked(input_name);
            });

            // init_DataTables();
        }      
    </script>        
@stop
