{{-- 自動引入layouts.administration.blade.php 當為外層樣板 --}}
@extends('layouts.admin')

{{-- --------------- 最上方top -------------- --}}
@section('top')
    @parent
    <!-- JS -->
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>  <!-- CKEditor -->
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
                <h3>{{ trans_choice('system.system_title', 1, ['type1' => trans('default.default_basic_setting')]) }}</h3>
              </div>
            </div>            
            <form method="POST" action="{{ route('admin_system_index_edit') }}" id="main_form" data-parsley-validate class="form-horizontal form-label-left">
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
                      <h2>{{ trans('default.default_basic_setting') }}
                      </h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">                     
                      <br />   
                  {{-- Name 系統名稱 --}}                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          {{ trans('system.system_name_title') }}
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="name" value="{{ $system->name }}" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <br />
                  {{-- Image Upload LOGO --}}   
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> {{ trans('system.system_logo') }}
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="input-group">
                             <span class="input-group-btn">
                               <a id="image" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                 <i class="fa fa-picture-o"></i> {{ trans('default.default_choose') }}
                               </a>
                             </span>
                             <input id="thumbnail" class="form-control" type="text" name="image" value="{{ $system->image }}" readonly>
                           </div>
                           <img id="holder" style="margin-top:15px;max-height:100px;" src="{{ $system->image }}">
                        </div>
                      </div>  
                      <br /> 
                    </div>               
                  </div>
                </div>
              </div>
              {{-- ------------------ CKEditor 設定------------------ --}}  
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>
                        {{ trans('system.systemIndexContent_title') }} 
                      </h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                    {{-- CKEditor with Responsive FileSystem --}}
                      <textarea id="content" name="content" class="form-control">{{ $system->content or '' }}</textarea>
                      <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
                      <script>
                        var options = {
                          filebrowserImageBrowseUrl: '{{ route("filemanager"        , ["type" => "Images"]) }}',
                          filebrowserImageUploadUrl: '{{ route("filemanager_upload" , ["type" => "Images", "_token"]) }}',
                          filebrowserBrowseUrl:      '{{ route("filemanager"        , ["type" => "Files"]) }}',
                          filebrowserUploadUrl:      '{{ route("filemanager_upload" , ["type" => "Files", "_token"]) }}'
                        };
                      </script>
                      <script>
                      CKEDITOR.replace('content', options);
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
                        {{ trans('system.systemIndexSeo_title') }} 
                      </h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <br />
                  {{-- SEO Title 標題 --}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                          {{ trans('system.systemIndexSeo_seo_title') }}
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="seo_title" value="{{ $system->seo_title or '' }}" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                  {{-- SEO Description 敘述 --}}    
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                          {{ trans('system.systemIndexSeo_seo_description') }}
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="seo_description" value="{{ $system->seo_description or ''  }}" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                  {{-- SEO Keyword 關鍵字 --}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                          {{ trans('system.systemIndexSeo_seo_keyword') }}
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="seo_keyword" value="{{ $system->seo_keyword or ''  }}" class="form-control col-md-7 col-xs-12">
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
                        <button class="btn btn-primary" type="button" onclick="confirm_reset();">
                          {{ trans('default.default_reset') }}
                        </button>
                        <button type="button" class="btn btn-success" onclick="confirm_submit();">
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
      /* -------- Filemanager Initialize ----------*/
        $('#image').filemanager('image',{prefix:"{{ config('lfm.prefix') }}"});
        $('#file').filemanager('file',{prefix:"{{ config('lfm.prefix') }}"});
      /* -------- Sweet Alert ----------*/
      function confirm_submit()
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
          $('#main_form').submit();
        });
      }
      function confirm_reset()
      {
        swal({
          title: '{{ trans("default.default_confitm_reset") }}',
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
          document.getElementById("main_form").reset();
        });
      }      
    </script>        
@stop
