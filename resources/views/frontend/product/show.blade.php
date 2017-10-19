@extends('layouts.master')
@section('title', $product->name ?: 'Not Found')

@section('content')
<section class="section-single-product-page">
    <div class="container">
        <form class="custom" action="#">
            @if(!empty($product))
            <div class="row">
                <div id="product-gallery">
                    <div class="col-lg-6 col-md-12">
                        <div class="row">
                        @if (count(json_decode($product->images,true)) > 1)
                            <div class="col-xs-1 col-sm-3 hidden-xs">
                                <div class="single-product-vertical-gallery">
                                    <a class="fa fa-angle-up up-btn" href="#up"></a>
                                    <a class="fa fa-angle-down down-btn" href="#down"></a>
                                    <ul>
                                        @foreach(json_decode($product->images,true) as $key => $value)
                                        <li><a class="vertical-gallery-item" href="#slide{{$key}}"><img class="lazy" alt="{{ $product->name }}" src="{{ $value }}" /></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-11 col-sm-9">
                                <div class="single-product-gallery">
                                    <div class="nav-holder">
                                        <a class="fa fa-angle-right next-btn" href="#next"></a>
                                        <a class="fa fa-angle-left prev-btn" href="#prev"></a>
                                    </div>
                                    <div class="single-product-slider">
                                        @foreach(json_decode($product->images,true) as $key => $value)
                                        <div class="single-product-gallery-item" id="slide{{$key}}">
                                            <a data-rel="prettyphoto" href="{{ $value }}"><img alt="{{ $product->name }}" src="{{ $value }}" /></a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-xs-12">
                                <img temprop="image" class="lazy product-img" alt="{{ $product->name }}" src="{{ $images }}" />
                            </div>
                        @endif
                        </div>
                            <hr>
                            <h3>Related items</h3>
                            @foreach($related as $item)
                            <div class="row"><br>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <div class="product-item text-center">
                                      <a href="{{ url('product/'.$item->slug) }}">
                                        <img class="product-img" src="" alt="" />
                                      </a>
                                      <hr>
                                      <div class="title uppercase bold">
                                          <a href="{{ url('product/'.$item->slug) }}">{{ $product->name }}</a>
                                      </div>
                                      <div class="price">
                                        @if ($product->discount > 0)
                                          <span class="previous-price">{{ $product->price }}</span>
                                        @endif
                                          <span style="text-decoration: line-through;">
                                            {{ $product->price }}
                                          </span> <br /> {{ ($product->price - $product->discount) }}
                                      </div>
                                      @if ($product->discount > 0)
                                        <span class="salesign">SALE</span>
                                      @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                    </div>
                </div>
                    <div id="product-page">
                        <div class="col-lg-6 col-md-12">
                            <div class="single-product-info-holder">
                                <div class="nav-area-holder">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="back">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="brand">
                                </div>
                                <h1 itemprop="name">{{ $product->name }}</h1>
                                <div class="product-rating-container">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12">
                                                <!-- product ratings -->
                                        <p style="display: inline;">
                                            @if ($product->rating)
                                                <span style="margin-right: -4px">
                                                  &starf;
                                                </span>
                                                 {{ $product->rating }}
                                            @else
                                                &star;&star;&star;&star;&star;
                                                 (no reviews yet)
                                            @endif
                                                    @if ($product->rating)
                                                    <div class="modal fade" id="productReviewModal" tabindex="-1" role="dialog" aria-labelledby="productReviewModal">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                              <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h1 class="modal-title">{{ $product->name }}</h1>
                                                              </div>
                                                              <div class="modal-body">
                                                                <div class="row">
                                                                  <div class="col-xs-6 col-sm- 6">
                                                                    <p>
                                                                      @if ($product->rating)
                                                                        <span style="margin-right: -4px">
                                                                          &starf;&starf;&starf;&starf;
                                                                        </span>
                                                                        Based on 2
                                                                        reviews
                                                                      @endif
                                                                    </p>
                                                                  </div>
                                                                  <div class="col-xs-6 col-sm- 6 text-right">
                                                                    <a class="blue" href="#" data-dismiss="modal" onclick="writeReview();" id="write-review-inview"><strong>Write a Review</strong></a>
                                                                  </div>
                                                                </div>
                                                                <div class="reviews">
                                                                @foreach ($reviews as $review)
                                                                    @if($review->item_rating == 5)
                                                                        <div class="review-rating">&starf;&starf;&starf;&starf;&starf;</div>
                                                                    @elseif($review->item_rating == 4)
                                                                        <div class="review-rating">&starf;&starf;&starf;&starf;&star;</div>
                                                                    @elseif($review->item_rating == 3)
                                                                        <div class="review-rating">&starf;&starf;&starf;&star;&star;</div>
                                                                    @elseif($review->item_rating == 2)
                                                                        <div class="review-rating">&starf;&starf;&star;&star;&star;</div>
                                                                    @elseif($review->item_rating == 1)
                                                                        <div class="review-rating">&starf;&star;&star;&star;&star;</div>
                                                                    @endif
                                                                       <p class="review-date">{{ $review->created_at }}</p>
                                                                        <p><strong>{{ $review->title }}</strong></p>
                                                                        <p><em>{{ $review->comment }}</em></p>
                                                                        <p>{{ $review->from_name }}</p>
                                                                    <hr>
                                                                @endforeach
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>

                                                  <!-- View Review -->
                                                  <a id="view-review" href="#" data-toggle="modal" data-target="#productReviewModal">View Review(s)</a>&nbsp;&nbsp;|&nbsp;&nbsp;

                                                  <!-- Write Review -->
                                                  <a id="write-review" href="#" data-toggle="modal" data-target="#productWriteModal">Write Review</a>
                                                @else
                                                  <!-- Write Review -->
                                                  <a id="write-review" href="#" data-toggle="modal" data-target="#productWriteModal">Write Review</a>
                                                @endif
                                        </p>
                                            </div>
                                        </div>
                                </div>

                                <div class="price">
                                    @if ($product->discount > 0)
                                        <span class="previous-price">{{ $product->price }}</span>
                                    @endif
                                    <span  itemprop="price">{{ $product->price - ($product->price * $product->discount) }}</span>
                                </div>
                                @if(!empty($product->description))
                                    <div class="excerpt" itemprop="description">
                                        {{ $product->description }}
                                    </div>
                                @endif

                                @if ($product->active == TRUE)
                                    <div class="drop-down-holder">
                                        <!--@if (count(json_decode($product->optional)) > 0)
                                            @foreach(json_decode($product->optional) as $key => $value)
                                              <div class="inline prod-options">
                                                <h5 class="title" for="{{ $product->id }}">{{ $product->optional }}</h5>
                                                <select id="{{ $key }}" name="options[{{ $product->id }}]" class="product-option md-select" data-ajax-handler="shop:product" data-ajax-update="#product-page=shop-product">
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                </select>
                                              </div>
                                            @endforeach
                                        @endif
                                        -->
                                        @if (count(json_decode($product->optional)) > 0)
                                        <h5>Product Extras</h5>
                                          <div class="clearfix">
                                            @foreach(json_decode($product->optional) as $key => $value)
                                                <div class="extra">
                                                    <label class="title" for="{{ $key }}">
                                                          <input type="checkbox" id="{{ $key }}" name="extras[{{ $product->id }}]" data-ajax-handler="shop:product" data-ajax-update="#product-page=shop-product">
                                                      {{ $value }}
                                                    </label>
                                                </div>
                                            @endforeach
                                          </div>
                                        @endif
                                        <div class="quantity inline">
                                            <h5>Quantity</h5>
                                            <input class="md-input quantity" type="text" value="{{ old('quantity') }}" name="quantity"/>
                                        </div>
                                    </div>
                                    <div class="buttons-holder">
                                        <div class="add-cart-holder inline">
                                        @if ($product->stock > 0)
                                            <input type="hidden" name="productid" value="{{ $product->id }}"/>
                                            <button class="md-button addtocart" id="addtocart">Add to Cart</button>
                                            {{ $product->stock }}
                                            <i><span class="stock-remaining"> left in stock</span></i>
                                        @else
                                            <div class="not-available">
                                                <h5>This product is temporarily unavailable</h5>
                                            <div>
                                        @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="not-available">
                                        <h5>This product is not available</h5>
                                    <div>
                                @endif

                                <!--@if ($product->optional != NULL)
                                <div class="product-attributes">
                                        <div class="row">
                                            {% if product.priceTiers.count %}
                                          <div class="col-xs-12 col-sm-6">
                                            <h3>Bulk Pricing</h3>
                                                    <div>
                                                        <table class="volume-pricing-table">
                                                          <thead><tr><td>Qty</td><td>Price</td></tr></thead>
                                                          
                                                          {% for priceTier in product.priceTiers %}
                                                          <tr>
                                                            <td>
                                                              {% if loop.last %} {{-- {{priceTier.quantity}} --}}+
                                                              {% else %} {{-- {{ priceTier.quantity}} - {{product.priceTiers[loop.index].quantity - 1}} --}} {% endif %}
                                                            </td>
                                                            <td>{{ $product->price }}/each</td>
                                                          </tr>
                                                          {% endfor %}
                                                        </table>

                                                    </div>
                                          </div>
                                      {% endif %}
                                      {% if product.productAttributes.count %}
                                          <div class="col-xs-12 col-sm-6">
                                            <h3>Product Specs</h3>
                                            <div>
                                            <table class="attributes-table">
                                                  {{-- {% for attribute in product.productAttributes %}
                                                    <tr>
                                                      <td><strong>{{ attribute.name }}:</strong></td>
                                                      <td>{{ attribute.value }}</td>
                                                    </tr>
                                                  {% endfor %} --}}
                                                </table>

                                            </div>
                                          </div>
                                      {% endif %}
                                        </div>
                                </div>
                            @endif
                            -->

                                    <div class="social-buttons">
                                        <span>share with your friends</span>
                                        <ul class="inline list-inline square-icons">
                                            <li class="facebook"><a href="http://www.facebook.com/sharer/sharer.php?u=http:{{ url("product/$product->slug") }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                            <li class="twitter"><a href="https://twitter.com/intent/tweet?text={{ $product->name }} http:{{ url("product/$product->slug") }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                            <li class="gplus"><a href="http://pinterest.com/pin/create/button/?url=http:{{ url("product/$product->slug") }}&media={{ $product->images[0] }}" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                                        </ul>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <h2>We are sorry, the requested product was not found.</h2>
            @endif
        </form>

        <div id="write-modal">
            <div class="modal fade" id="productWriteModal" tabindex="-1" role="dialog" aria-labelledby="productWriteModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h1 class="modal-title">{{ $product->name }}</h1>
                  </div>
                        <div class="modal-body">
                            <div class="panel-body section-contact-form">
                                <form data-ajax-handler="system:onSendMessage">
                                    <div class="row field-row">
                                        <div class="col-xs-12 col-sm-12">
                                            <input type="text" class="required md-input" id="contact_name" name="fields[name]" value="" placeholder="Your name"/>
                                            <span class="error"></span>
                                        </div>
                                    </div>

                                    <div class="row field-row">
                                        <div class="col-xs-12 col-sm-12">
                                            <input type="text" class="required md-input" id="contact_email" name="fields[email]" value="" placeholder="Email address"/>
                                            <span class="error"></span>
                                        </div>
                                    </div>

                                    <div class="row field-row">
                                        <div class="col-xs-12 col-sm-12">
                                            <input type="text" class="required md-input" id="subject" name="fields[subject]" value="" placeholder="Title for your review"/>
                                            <span class="error"></span>
                                        </div>
                                    </div>

                                    <div class="row field-row">
                                        <div class="col-xs-12 col-sm-12">
                                            <textarea class="required md-input" id="contact_message" name="fields[message]" value="" rows="10" placeholder="Your review"></textarea>
                                            <span class="error"></span>
                                        </div>
                                    </div>

                                    <div class="rating">
                                        <span id="love">☆</span><span id="like">☆</span><span id="ok">☆</span><span id="dont-like">☆</span><span id="hate">☆</span>
                                        <p>&nbsp;</p>
                                    </div>

                                    <select style="display:none" id="item_rating" name="fields[item_rating]">
                                        <option value="" diabled>-</option>
                                        <option value="1">&starf;&star;&star;&star;&star;</option>
                                        <option value="2">&starf;&starf;&star;&star;&star;</option>
                                        <option value="3">&starf;&starf;&starf;&star;&star;</option>
                                        <option value="4">&starf;&starf;&starf;&starf;&star;</option>
                                        <option value="5">&starf;&starf;&starf;&starf;&starf;</option>
                                    </select>
                                    <span class="error"></span>

                                    <input type="submit" class="md-button" value="Submit" style="width: 100%"/>
                                    <input type="text" name="hp" value="" style="display: none"/>
                                    <input type="hidden" name="fields[shop_customer_id]" value=""/>
                                    <input type="hidden" name="fields[shop_product_id]" value="{{ $product->id }}"/>
                                    <input type="hidden" name="template" value="system:product-review"/>
                                    <input type="hidden" name="fields[message_type]" value="review"/>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>       
    </div>
</section>
@endsection