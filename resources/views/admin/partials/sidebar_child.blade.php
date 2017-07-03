@if(count($category['childs'])>0)
	<li><a >{{ $category['category']->name }}<span class="fa fa-chevron-down"></span></a>
		<ul class="nav child_menu">
		        @foreach($category['childs'] as $category)
		            @include('admin.partials.sidebar_child', ['category' => $category, 'i' => isset($i) ? $i : 1])
		        @endforeach
		</ul>
	</li>
@else
	<li><a href="#{{ $category['category']->product_category_id }}">{{ $category['category']->name }}</a>
@endif
			<!-- 外圍 -->
              <!-- <li>
                <a>{{ trans('product.product_sidebar_category') }}<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu" id="product_categories_ul_container">
                  @each('admin.partials.sidebar_child',$productCategories,'category')
                </ul>
              </li>   -->
