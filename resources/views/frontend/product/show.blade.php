<section class="section-single-product-page">
    <div class="container">
        <form class="custom" onsubmit="return false">
            @if($product)
                <div class="row" itemscope itemtype="http://data-vocabulary.org/Product">

                    <div id="product-gallery">
                        <div class="col-lg-6 col-md-12">
                            <div class="row">
                            @php $images = json_decode($product->images,true)
                            @endphp
                            @if (count($images) > 1)
                                <div class="col-xs-1 col-sm-3 hidden-xs">
                                    <div class="single-product-vertical-gallery">
                                        <a class="fa fa-angle-up up-btn" href="#up"></a>
                                        <a class="fa fa-angle-down down-btn" href="#down"></a>
                                        <ul>
                                            @foreach($images as $key => $value)
                                            <li>
                                                <a class="vertical-gallery-item" href="#slide{{$key}}">
                                                    <img class="lazy" alt="{{ $product->name }}" src="{{ $value }}" />
                                                </a>
                                            </li>
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
                                            @foreach($images as $key => $value)
                                            <div class="single-product-gallery-item" id="slide{{$key}}">
                                                <a data-rel="prettyphoto" href="{{ $value }}">
                                                    <img alt="{{ $product->name }}" src="{{ $value }}" />
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-xs-12">
                                    <img temprop="image"  class="lazy product-img" alt="{{ $product->name }}" src="{{ $images }}" />
                                </div>
                            @endif
                            </div>

                                <hr>
                                <h3>Related items</h3>
                                <div class="row"><br>

                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                      <form class="custom" onsubmit="return false">
                                        <div class="product-item text-center">
                                          <a href="/product/">
                                            <img class="product-img" src="{{ $product->images[0] }}" alt="{{ product.name }}" />
                                          </a>
                                          <hr>
                                          <div class="title uppercase bold">
                                              <a href="/product/">{{ $product->name }}</a>
                                          </div>
                                          <div class="price">
                                            @if ($product->discount > 0)
                                              <span class="previous-price">{{ product.fullPrice|currency }}</span>
                                            @endif
                                              <span style="text-decoration: line-through;">
                                                {{ $product->price }}
                                              </span> <br /> {{ ($product->price - $product->discount) }}
                                          </div>
                                          @if ($product->discount > 0)
                                            <span class="salesign">SALE</span>
                                          @endif
                                        </div>
                                      </form>
                                    </div>

                                </div>

                        </div>

                    </div>

                    <div id="product-page">
                        <div class="col-lg-6 col-md-12" itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer">
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
                                <h1 itemprop="name">{{ product.name }}</h1>

                                {{-- {% if theme.ratingToggle %} --}}
                                <div class="product-rating-container">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12">
                                                <!-- product ratings -->
                                        <p style="display: inline;">
                                            @if ($product->rating)
                                                <span style="margin-right: -4px">
                                                  &starf;
                                                </span>
                                                 ($product->rating)
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
                                                                <h1 class="modal-title">{{ product.name }}</h1>
                                                              </div>
                                                              <div class="modal-body">
                                                                <div class="row">
                                                                  <div class="col-xs-6 col-sm- 6">
                                                                    <p>
                                                                      @if ($product->rating->review)
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



                                                                        {% for review in product.reviews() %}

                                                                            {% if review.item_rating == 5 %}
                                                                                <div class="review-rating">&starf;&starf;&starf;&starf;&starf;</div>
                                                                            {% endif %}
                                                                            {% if review.item_rating == 4 %}
                                                                                <div class="review-rating">&starf;&starf;&starf;&starf;&star;</div>
                                                                            {% endif %}
                                                                            {% if review.item_rating == 3 %}
                                                                                <div class="review-rating">&starf;&starf;&starf;&star;&star;</div>
                                                                            {% endif %}
                                                                            {% if review.item_rating == 2 %}
                                                                                <div class="review-rating">&starf;&starf;&star;&star;&star;</div>
                                                                            {% endif %}
                                                                            {% if review.item_rating == 1 %}
                                                                                <div class="review-rating">&starf;&star;&star;&star;&star;</div>
                                                                            {% endif %}


                                                                                <p class="review-date">{{ review.created_at|date('M jS, Y') }}</p>




                                                                                <p><strong>{{ review.title }}</strong></p>
                                                                                <p><em>{{ review.comment }}</em></p>


                                                                                <p>{{ review.from_name }}</p>



                                                                            <hr>
                                                                        {% endfor %}
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>

                                              <!-- View Review -->
                                              <a id="view-review" href="#" data-toggle="modal" data-target="#productReviewModal">View Review(s)</a>&nbsp;&nbsp;|&nbsp;&nbsp;

                                              <!-- Write Review -->
                                              <a id="write-review" href="#" data-toggle="modal" data-target="#productWriteModal">Write Review</a>
                                            {% else %}
                                              <!-- Write Review -->
                                              <a id="write-review" href="#" data-toggle="modal" data-target="#productWriteModal">Write Review</a>
                                            {% endif %}
                                        </p>
                                            </div>

                                        </div>





                                </div>
                            {% endif %}

                                <div class="price">
                                    {% if on_sale %}
                                        <span class="previous-price">{{ product.fullPrice|currency }}</span>
                                    {% endif %}
                                    <span  itemprop="price">{{ product.price|currency }}</span>
                                    <meta itemprop="currency" content="USD" />
                                </div>
                                {% if product.description %}
                                    <div class="excerpt" itemprop="description">
                                        {{ product.description|unescape }}
                                    </div>
                                {% endif %}

                                @if ($product->active == TRUE)
                                    <div class="drop-down-holder">
                                        @if (count(json_decode($product->optional)) > 0)
                                            @foreact(json_decode($product->optional) as $key => $value)
                                              <div class="inline prod-options">
                                                <h5 class="title" for="{{ $product->id }}">{{ $product->optional }}</h5>
                                                <select id="{{ $key }}" name="options[{{ $product->id }}]" class="product-option md-select" data-ajax-handler="shop:product" data-ajax-update="#product-page=shop-product">
                                                  {% for key, value in option.values %}
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                  {% endfor %}
                                                </select>
                                              </div>
                                            @endforeach
                                        @endif
                                        {% if product.extras.count %}
                                        <h5>Product Extras</h5>
                                          <div class="clearfix">
                                            {% for index, extra in product.extras %}
                                                <div class="extra">
                                                    <label class="title" for="{{ 'extra-'~index }}">
                                                      {% if extra.enabled %}
                                                          <input type="checkbox" id="{{ 'extra-'~index }}" {{ checkbox_state(postedExtras[extra.id], extra.id) }} name="extras[{{ extra.id }}]" data-ajax-handler="shop:product" data-ajax-update="#product-page=shop-product">
                                                      {% else %}
                                                          <input type="checkbox" disabled="disabled">
                                                      {% endif %}
                                                      {{ extra.name }} ({{ extra.price|currency }})
                                                    </label>
                                                </div>
                                            {% endfor %}
                                          </div>
                                        {% endif %}


                                        <div class="quantity inline">
                                            <h5>Quantity</h5>
                                            <input class="md-input quantity" type="text" value="{{ quantity|default("1") }}" name="quantity"/>
                                        </div>
                                    </div>
                                    <div class="buttons-holder">
                                        <div class="add-cart-holder inline">
                                        {% if not product.isOutOfStock() or product.allow_preorder %}
                                            <input type="hidden" name="productId" value="{{ product.id }}"/>
                                            <a class="md-button" href="#" data-ajax-handler="shop:onAddToCart" data-ajax-update="#mini-cart=shop-minicart, #product-page=shop-product">Add to Cart</a>
                                            {% if product.in_stock_amount %}<div><i><span class="stock-remaining">{{ product.in_stock_amount }} left in stock</span></i></div> {% endif %}
                                        {% else %}
                                            <div class="not-available">
                                                <h5>This product is temporarily unavailable</h5>
                                            <div>
                                        {% endif %}
                                        </div>
                                    </div>
                                {% else %}
                                    <div class="not-available">
                                        <h5>This product is not available</h5>
                                    <div>
                                {% endif %}

                                {% if product.priceTiers.count or product.productAttributes.count %}
                                <div class="product-attributes">
                                        <div class="row">
                                            {% if product.priceTiers.count %}
                                          <div class="col-xs-12 col-sm-6">
                                            <h3>Bulk Pricing</h3>
                                                    <div>
                                                        <table class="volume-pricing-table">
                                                          <thead><tr><td>Qty</td><td>Price</td></tr></thead>
                                                          {{ item }}
                                                          {% for priceTier in product.priceTiers %}
                                                          <tr>
                                                            <td>
                                                              {% if loop.last %} {{priceTier.quantity}}+
                                                              {% else %} {{ priceTier.quantity}} - {{product.priceTiers[loop.index].quantity - 1}} {% endif %}
                                                            </td>
                                                            <td>{{priceTier.price|currency}}/each</td>
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
                                                  {% for attribute in product.productAttributes %}
                                                    <tr>
                                                      <td><strong>{{ attribute.name }}:</strong></td>
                                                      <td>{{ attribute.value }}</td>
                                                    </tr>
                                                  {% endfor %}
                                                </table>

                                            </div>
                                          </div>
                                      {% endif %}
                                        </div>
                                </div>
                            {% endif %}

                                {% if theme.socialToggle %}
                                    <div class="social-buttons">
                                        <span>share with your friends</span>
                                        <ul class="inline list-inline square-icons">
                                            <li class="facebook"><a href="http://www.facebook.com/sharer/sharer.php?u=http:{{ site_url('/') }}product/{{ product.url_name}}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                            <li class="twitter"><a href="https://twitter.com/intent/tweet?text={{ product.name }} http:{{ site_url('/') }}product/{{ product.url_name}}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                            <li class="gplus"><a href="http://pinterest.com/pin/create/button/?url=http:{{ site_url('/') }}product/{{ product.url_name}}&media={{ product.images.first.thumbnail(746, 'auto') }}" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                                        </ul>
                                    </div>
                                {% endif %}

                            </div>
                        </div>
                    </div>
                </div>
            {% else %}
                <h2>We are sorry, the requested product was not found.</h2>
            {% endif %}
        </form>

        <div id="write-modal">
    <div class="modal fade" id="productWriteModal" tabindex="-1" role="dialog" aria-labelledby="productWriteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h1 class="modal-title">{{ product.name }}</h1>
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
                            <input type="hidden" name="fields[shop_customer_id]" value="{{customer.id}}"/>
                            <input type="hidden" name="fields[shop_product_id]" value="{{product.id}}"/>
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