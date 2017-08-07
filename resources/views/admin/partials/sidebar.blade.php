<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="{{ route('admin_index') }}" class="site_title">
        <!-- <i class="fa fa-paw"></i> <span>Gentelella Alela!</span> -->
        <img width="230px" height="57px" src="{{ $system->image }}" alt="user picture" >
      </a>
    </div>
    <div class="clearfix"></div>
    {{-- ------------------- menu profile quick info ----------------- --}}
    <div class="profile clearfix">
      <div class="profile_pic">
        <img src="{{ Auth::user()->image }}" alt="user picture" class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>{{ trans('default.default_welcome') }}</span>
        <h2>{{ Auth::user()->name }}</h2>
      </div>
    </div>
    <br />

  {{-- --------------------- sidebar menu ---------------------- --}}
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
      {{-- -------------------- 系統管理 System -------------------- --}} 
      @if(Auth::user()->can('system_index_view') || Auth::user()->can('system_index_edit'))        
          <li><a><i class="fa fa-cog"></i> {{ trans('system.system_sidebar_title') }} <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="{{ route('admin_system_index') }}">{{ trans('default.default_basic_setting') }}</a></li>
              <li><a href="index2.html">郵件管理</a></li>
              <li><a href="index3.html">Dashboard3</a></li>
            </ul>
          </li> 
      @endif
      {{-- -------------------- 會員中心 Member -------------------- --}}      
      @if(Auth::user()->can('member_index_view') || Auth::user()->can('member_index_edit') || Auth::user()->can('member_category_view') || Auth::user()->can('member_category_edit') || Auth::user()->can('member_item_view') || Auth::user()->can('member_item_edit'))  
          <li><a><i class="fa fa-cog"></i> {{ trans_choice('member.member_title', 0) }} <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu"> 
            @if(Auth::user()->can('member_index_view') || Auth::user()->can('member_index_edit'))
              <li><a href="{{ route('admin_member_index') }}">{{ trans('member.member_basic_setting') }}</a></li>
            @endif  
            @if(Auth::user()->can('member_category_view') || Auth::user()->can('member_category_edit'))
              <li><a href="{{ route('admin_member_category') }}">{{ trans('member.memberCategoryIndex_category_list') }}</a></li>
            @endif  
            @if(Auth::user()->can('member_item_view') || Auth::user()->can('member_item_edit'))
              <li><a href="{{ route('admin_member_item') }}">{{ trans('member.member_sidebar_item') }}</a></li>
            @endif  
            </ul>
          </li>  
      @endcan    
      {{-- -------------------- 最新消息 News -------------------- --}} 
      @if(Auth::user()->can('news_index_view') || Auth::user()->can('news_index_edit') || Auth::user()->can('news_category_view') || Auth::user()->can('news_category_edit') || Auth::user()->can('news_item_view') || Auth::user()->can('news_item_edit'))            
          <li><a><i class="fa fa-newspaper-o"></i> {{ trans('news.news_title') }} <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
          {{-- 基本設定 --}}
            @if(Auth::user()->can('news_index_view') || Auth::user()->can('news_index_view'))
              <li>  
                <a href="{{ route('admin_news_index') }}">
                  {{ trans('news.newsIndex_title') }}
                </a>
              </li>  
            @endif   
          {{-- 分類 --}}  
            @if(Auth::user()->can('news_category_view') || Auth::user()->can('news_category_edit'))
              <li>
                <a href="{{ route('admin_news_category') }}">
                  {{ trans('news.newsCategory_title') }}
                </a>
              </li> 
            @endif  
          {{-- 列表 --}}  
            @if(Auth::user()->can('news_item_view') || Auth::user()->can('news_item_edit'))
              <li>
                <a href="{{ route('admin_news_item') }}">
                  {{ trans('news.newsItem_title') }}
                </a>
              </li>
            @endif    
            </ul>
          </li> 
      @endif           
      {{-- -------------------- 商品 Product -------------------- --}} 
      @if(Auth::user()->can('product_index_view') || Auth::user()->can('product_index_edit') || Auth::user()->can('product_category_view') || Auth::user()->can('product_category_edit') || Auth::user()->can('product_item_view') || Auth::user()->can('product_item_edit'))  
          <li>
            <a>
              <i class="fa fa-circle"></i> 
              {{ trans_choice('product.product_title',0) }}
              <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu">
          {{-- 基本設定 --}}
          @if(Auth::user()->can('product_index_view') || Auth::user()->can('product_index_edit')) 
              <li>
                <a href="{{ route('admin_product_index') }}">
                  @lang('default.default_basic_setting')
                </a>
              </li>
          @endif 
          {{-- 分類 --}}  
          @if(Auth::user()->can('product_category_view') || Auth::user()->can('product_category_edit')) 
              <li>
                <a href="{{ route('admin_product_category') }}">
                  @lang('default.default_category')
                </a>
              </li> 
          @endif                
          {{-- 列表 --}} 
          @if(Auth::user()->can('product_item_view') || Auth::user()->can('product_item_edit'))             
              <li>
                <a href="{{ route('admin_product_item') }}">
                  @lang('default.default_data')
                </a>
              </li>
          @endif  
            </ul>
          </li>  
      @endif                
        </ul>
      </div>
    </div>

    {{-- ---------------------- menu footer buttons --------------------- --}}
    <div class="sidebar-footer hidden-small">
      <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div>
  </div>
</div>