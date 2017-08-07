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
    <script src="{{ asset('vendors/dropzone/dist/min/dropzone.min.js') }}"></script>  <!-- DropZone -->
    <script src="{{ asset('colorbox-master/jquery.colorbox.js') }}"></script>   <!-- ColorBox -->
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
                <h3>{{ trans_choice('member.member_title',2,['type1' => trans('default.default_category'),
                                                             'type2' => trans('default.default_create')]) }}</h3>
              </div>
            </div>
            <form method="POST" action="{{ route('admin_member_category_create') }}" id="main_form" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
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
                      <h2>{{ trans('member.memberCategory_basic_setting') }} 
                      </h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                  {{-- Name 標題 --}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          {{ trans('member.memberCategoryIndex_category_title') }}
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="name" value="{{ old('name') }}" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <br /> 
                    </div>               
                  </div>
                </div>
              </div>
          {{-- ------------------ 權限 設定------------------ --}}             
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>
                        {{ trans('member.memberCategory_permission_setting') }}
                      </h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li>
                          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                  {{-- 最新消息權限 --}}
                      <div class="form-group">

                        @foreach(config('permission.permissions') as $model_key => $model_value)
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ $model_value['display_name'] }}
                          </label>
                          <br>
                          <div style="padding: 5px;position: relative;margin-left: 25%;margin-right: 25%">  
                          @foreach($model_value['value'] as $group_key => $group_value)                  
                          <table class="table">
                            <tr>
                              <td width="30%">
                                <label>{{ $group_value['display_name'] }}</label>
                              </td>
                              <td width="70%">
                                <label>
                                  <input type="checkbox" class="flat " />全選
                                </label>
                              </td>
                            </tr>
                            <tr>
                              <td></td>
                              <td>
                                <ul class="nav">
                                @foreach($group_value['value'] as $permission_key => $permission_value)
                                  <li>
                                    <label>
                                      <input type="checkbox" name="permission[]" value="{{ $permission_value['name'] }}" required class="flat " @if(old('permission') && in_array($permission_value['name'],old('permission'))) checked @endif/> {{ $permission_value['display_name'] }}
                                    </label>
                                  </li>
                                @endforeach
                                </ul>
                                </td>
                            </tr>
                          </table>
                          @endforeach
                          </div>
                        @endforeach
                        
                      </div>  
                  {{-----------}}

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
                        <button type="button" class="btn btn-primary" id="reset_btn">
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
      });
    </script>        
@stop
