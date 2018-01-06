@extends('layouts.master')
@section('title', 'Shop')

@section('content')

<section id="products-grid-sidebar" class="section-products-grid">
    <div class="container">
        <div class="col-xs-12 col-md-3">
            <div class="sidebar">
                <div class="accordion-widget category-accordions">
                    
                    <h2>Categories</h2>
                    
                    @if(count($categories) > 0)
                    <div class="accordion" >
                        @foreach($categories as $category)
                        <div class="accordion-group">
                            <div class="accordion-heading">
                            @if ($category->children > 0)
                                    <a class="accordion-toggle" data-toggle="collapse" href="#collapse{{ $category->id }}">{{ $category->name }}</a>
                            </div>
                            <div id="collapse{{$category->id}}" class="accordion-body collapse in">
                                <div class="accordion-inner">
                                    <a href="/category/{{ $category->slug }}">All {{ $category->name }}</a>
                                    @foreach($category->childs as $child)
                                    <ul>
                                            <li>
                                                <a href="/category/{{ $category->slug }}">{{ $category->name }}</a>
                                            </li>
                                    </ul>
                                    @endforeach
                                </div>
                            </div>
                            @else
                                <a class="accordion-toggle direct-link" href="/category/{{ $category->slug }}">{{ $category->name }}</a>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif                    
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-9">
            
            @if (count($categories) < 1)
                <h2>Category not found</h2>
                <p>We are sorry, the requested category was not found.</p>
            @else
            <div class="banner">
                <img alt="" class="lazy" src="images/homepage-3-banner.jpg" />
            </div>
            <div class="row">
                <div class="col-xs-6">
                </div>
                <div class="col-xs-6">
                    <div class="grid-list-buttons">
                        <ul class="list-inline">
                            <li class="active"><a data-toggle="tab" href="#grid-view"><i class="fa fa-th-large"></i> Grid</a></li>
                            <li ><a data-toggle="tab" href="#list-view"><i class="fa fa-th-list"></i> List</a></li>
                        </ul>
                    </div>
                </div>
            </div>            
            

                <div class="product-grid no-move-down tab-content">
    
                    <!-- grid view starts here -->
                    <div id="grid-view" class="tab-pane active">
                        
                       <div class="row">
                            @if(count($products) > 0)
                                @foreach ($products as $product)
                                    <div class="col-lg-4 col-xs-12 col-sm-6 product-holder">
                                        <form class="custom" onsubmit="return false">
                                        <div class="product-item text-center">
                                            @php 
                                            $images = json_decode($product->images, TRUE);
                                            @endphp
                                            @if (count($images) > 1)
                                                <a href="#next" class="mini-next"></a>
                                                <a href="#prev" class="mini-prev"></a>
                                                <div class="image ">
                                                    <div class="product-mini-gallery">
                                                        @foreach ($images as $key => $value)
                                                        <a style="display:inline-block;" href="/product/{{ $product->slug }}">
                                                            <img alt="{{ $product->name }}" src="{{ $value }}" width="212" height="281" />
                                                        </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <a href="/product/{{ $product->slug }}">
                                                    <img class="product-img" src="{{ $images }}" alt="{{ $product->name }}" />
                                                </a>
                                            @endif
                                            <hr>
                                            <div class="title uppercase bold">
                                                <a href="/product/{{ $product->slug }}">{{ $product->name }}</a>
                                            </div>
                                            <div class="price">
                                                @if ($product->is_discount == TRUE)
                                                        <span class="previous-price">{{ $product->pricet - ($product->discount * $product->price) }}</span>
                                                @endif
                                                <span>{{ $product->price }}</span>
                                            </div>
                                            <div class="buttons-holder">
                                                <div class="add-cart-holder">
                                                    <input type="hidden" name="productId" value="{{ $product->id }}"/>
                                                    <a class="md-button" href="#" data-ajax-handler="shop:onAddToCart" data-ajax-update="#mini-cart=shop-minicart, #product-page=shop-product">Add to Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-xs-12">
                                    <h2 class="empty">There are no products in this category.</h2>
                                </div>
                            @endif
                        </div>
    
                    </div>
                    <!-- List View starts here-->
                    <div id="list-view" class="tab-pane">
                    
                       <div class="products-list-holder">
                            @if (count($products) > 1)
                            @foreach($products as $product)
                            <form class="custom" onsubmit="return false">
                            <div class="product-list-item">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4">
                                        <div class="image-holder">
                                        @php $images = json_decode($product->images)
                                        @endphp
                                            <a href="/product/{{ $product->slug }}"><img class="product-img" alt="{{ $product->name }}" src="{{ $images[0] }}" /></a> 
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="item-details-holder">
                                            <h2 class="title" ><a href="/product/{{ $product->slug }}">{{ $product->name }}</a></h2>
                                            <div class="excerpt">
                                                {{ $product->description }}
                                            </div>
                                            
                                            <div class="price">
                                                @if ($product->is_discount == TRUE)
                                                        <span class="previous-price">{{ $product->pricet - ($product->discount * $product->price) }}</span>
                                                @endif
                                                <span>{{ $product->price }}</span>
                                            </div>
                                            <div class="buttons-holder">
                                                <div class="add-cart-holder">
                                                    <input type="hidden" name="productId" value="{{ $product->id }}"/>
                                                    <a class="md-button" href="#" data-ajax-handler="shop:onAddToCart" data-ajax-update="#mini-cart=shop-minicart, #product-page=shop-product">Add to Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                            @endforeach
                            @else
                                <h2 class="empty">There are no products in this category.</h2>
                            @endif
                        </div>
                    
                    </div>
                        
                </div>
                
                <!--<div class="paging-holder">-->
                    {{ $products->links('vendor.pagination.default') }}
                <!--</div>
                
                    
            @endif
        </div>
    </div>
</section>

@endsection