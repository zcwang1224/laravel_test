{{-- 自動引入layouts.administration.blade.php 當為外層樣板 --}}
@extends('layouts.admin')

{{-- --------------- 最上方top -------------- --}}
@section('top')
    @parent
    <!-- CSS -->
    <link href="{{ asset('vendors/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">  <!-- DropZone -->
    <link rel="stylesheet" href="{{ asset('colorbox-master/colorbox.css') }}" />  <!-- ColorBox -->
    <!-- JS -->
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>  <!-- CKEditor -->
  
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
                <h3>{{ trans_choice('product.product_title',2,['type1' => trans('default.default_item'),
                                                        'type2' => trans('default.default_create')]) }}</h3>
              </div>
            </div>
            <form method="POST" action="{{ route('admin_product_item_create') }}" id="main_form" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
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
                        {{ trans('default.default_basic_setting') }}
                      </h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                  {{-- Category 分類 --}}
                      <br />
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('product.productItem_item_category') }}</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control" name="product_category">
                          @foreach($productCategories as $key => $productCategory)
                            <option value="{{ $productCategory->product_category_id }}">{{ $productCategory->name }}</option>
                          @endforeach               
                          </select>
                        </div>
                      </div>                     
                      <br />
                  {{-- 商品 標題 --}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                          {{ trans('product.productItem_item_title') }}
                         <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="name" value="" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
                      <br /> 
                  {{-- 商品 描述 1 --}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('product.productItem_item_description1') }}
                         <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea name="description1" class="form-control col-md-7 col-xs-12"></textarea>
                        </div>
                      </div> 
                      <br /> 
                  {{-- 商品 描述 2 --}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('product.productItem_item_description2') }}
                         <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea name="description2" class="form-control col-md-7 col-xs-12"></textarea>
                        </div>
                      </div> 
                      <br /> 
                  {{-- Image Upload 圖片上傳 --}} 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> {{ trans('product.productItem_item_image') }}
                         <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" name="image" id="fileUpload" class="form-control col-md-7 col-xs-12">
                          <div id="image-holder">
                         </div>
                        </div>
                      </div>  
                  {{-- Status 分類狀態 --}}
                      <br />                                            
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('product.productItem_item_status') }}
                         <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label>
                            <input type="checkbox" name="status" class="js-switch" value="1"/> {{ trans('default.default_checked') }}
                          </label>
                        </div> 
                      </div>                                             
                    </div>
                  </div>
                </div>
              </div>
              {{-- ------------------ CKEditor 設定 - content1 ------------------ --}}  
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>{{ trans('product.productItem_item_content') }} 
                      {{-- <small>different form elements</small> --}}
                      </h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
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
                      <h2>{{ trans('product.productItem_item_content') }} 
                      {{-- <small>different form elements</small> --}}
                      </h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
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
                      </script>
                      <script>
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
                      <h2>{{ trans('product.productItem_item_content') }} 
                      {{-- <small>different form elements</small> --}}
                      </h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
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
                      </script>
                      <script>
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
                      <h2>{{ trans('product.productItem_item_content') }} 
                      {{-- <small>different form elements</small> --}}
                      </h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
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
                      </script>
                      <script>
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
                      <h2>
                        {{ trans('product.productItem_item_seo_setting') }}
                      </h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('product.productItem_item_seo_title') }}
                         <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="seo_title" value="" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">{{ trans('product.productItem_item_seo_description') }}
                        <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="seo_description" value="" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">{{ trans('product.productItem_item_seo_keyword') }}
                        <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="seo_keyword" value="" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>  
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
                        <button type="button" class="btn btn-primary" id="cancel_btn">
                          {{ trans('default.default_cancel') }}
                        </button>
                        <button type="button"  class="btn btn-primary" id="reset_btn">
                          {{ trans('default.default_reset') }}
                        </button>
                        <button type="button" class="btn btn-success" id="submit_btn">
                          {{ trans('default.default_submit') }}
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div> 
            </form>           
          </div>
        </div>
        <script>
          $(document).ready(function(){

          /* -------- SweetAlert 2 - Submit Confirm ----------*/
              $('#submit_btn').on('click',function(){

                swal({
                  title: '{{ trans("default.default_confirm_create") }}',
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
          /* -------- FileReader - 預覽圖片 ----------*/
              $("#fileUpload").on('change', function() {
                var countFiles = $(this)[0].files.length;
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#image-holder");
                image_holder.empty();
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                  if (typeof(FileReader) != "undefined") {
                    //loop for each file selected for uploaded.
                    for (var i = 0; i < countFiles; i++) 
                    {
                      var reader = new FileReader();
                      reader.onload = function(e) {
                        $("<img />", {
                          "src": e.target.result,
                          "class": "thumb-image"
                        }).appendTo(image_holder);
                      }
                      image_holder.show();
                      reader.readAsDataURL($(this)[0].files[i]);
                    }
                  } else {
                    alert("This browser does not support FileReader.");
                  }
                } else {
                  alert("Pls select only images");
                }
              });
          }); //end of document.ready
        </script>         
@stop
