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
                <h3>{{ trans_choice('product.product_title',1,['type1' => trans('default.default_basic_setting')]) }}</h3>
              </div>
            </div>            
            <form method="POST" action="{{ route('admin_product_index_edit') }}" id="main_form" data-parsley-validate class="form-horizontal form-label-left">
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
          {{-- ------------------ SEO 設定------------------ --}}             
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>{{ trans('product.productIndexSeo_title') }} 
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
                  {{-- SEO Title 標題 --}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">{{ trans('product.productIndexSeo_seo_title') }}
                         <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="seo_title" value="{{ $product->seo_title or '' }}" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                  {{-- SEO Description 敘述 --}}    
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">{{ trans('product.productIndexSeo_seo_description') }}
                        <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="seo_description" value="{{ $product->seo_description or ''  }}" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                  {{-- SEO Keyword 關鍵字 --}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">{{ trans('product.productIndexSeo_seo_keyword') }}
                        <!-- <span class="required">*</span> -->
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="seo_keyword" value="{{ $product->seo_keyword or ''  }}" class="form-control col-md-7 col-xs-12">
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
                      <h2>{{ trans('product.productIndexContent_title') }} 
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
                      <textarea id="content" name="content" class="form-control">{{ $product->content or '' }}</textarea>
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

              {{-- ------------------ 送出按鈕 ------------------ --}}
              @if(Auth::user()->can('product_index_edit'))
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
              @endif
            </form>                   
          </div>
        </div>
    <script>
      $(document).ready(function(){
        //Examples of how to assign the Colorbox event to elements
        // $(".color_box_test").colorbox({iframe:true, width:"80%", height:"80%",href:"{{ route('admin_index') }}"});
        var $iframe = $('.color_box_test');
        // $(".color_box_test").colorbox({iframe:false, width:"80%", height:"80%",href: $iframe.attr('href')+' #main'});
         $(".color_box_test").colorbox({ inline:true,width:"80%", height:"80%",href: $(".color_box_test").attr('href') + " #main"});


      });

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
