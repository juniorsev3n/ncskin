@extends('layouts.master')
@section('title', 'About')


@section('content')
<section class="section-aboutus-page">
    <div class="banner">
        <img alt="" class="lazy" src="images/homepage-3-banner.jpg" />  
    </div>
    <div class="container">
        <div class="row about-us-top">

            <div class=" col-sm-12 col-md-5">

                <div class="map-holder">
                     <div id="map" class="map center"></div> 
                </div>
            </div>
            <div class=" col-sm-12 col-md-7">
                <div class="content-holder about-us">
                    <h3>Sed eleifend ipasum id auctor ultrices roin consectetur tincidunt dignissim.</h3>
                    <p>

                        <strong>Aenean placerat tempus iaculis. In venenatis quis elit ut facilisis.</strong> Sed nec massa accumsan est egestas mollis vitae id mi. Aenean et laoreet velit. Pellentesque nec massa pellentesque, tempus purus lacinia, vestibulum eros. 
                    </p>
                    <p>
                        Cras porttitor sagittis ipsum, eu molestie tellus accumsan quis. Nam lectus nibh, lobortis sodales tempor vitae, tincidunt sit amet metus. Donec posuere lectus lacus, condimentum scelerisque leo fringilla sed. Suspendisse eu lorem vulputate nisl consectetur sollicitudin. <a href="#">Pellentesque accumsan luctus porta.</a>
                    </p>

                    <blockquote class="md-quote">
                        <p>Sed malesuada diam sed felis volutpat, quis convallis leo ullamcorper. Vestibulum dictum tortor in nisi gravida suscipit. </p>
                    </blockquote>
                </div>
            </div>
        </div>
        <hr>
        <div class="row members-holder">
            <div  class="col-xs-12 col-sm-6 col-lg-3  ">
                <div class="member-item">
                    <div class="image">
                        <img class="lazy" alt="" src="images/team-member-01.png" />
                    </div>
                    <div class="member-info">
                        <span class="name">Michał Kowalski</span><span class="devider">|</span><span class="position">Designer</span>
                        <p>
                            Cras porttitor sagittis ipsum, eu molestie tellus accumsan quis. Nam lectus nibh, lobortis sodales tempor vitae.
                        </p>
                        <ul class="list-inline member-socials">
                            <li><a class="fa fa-facebook" href="#fb"></a></li>
                            <li><a class="fa fa-twitter" href="#tw"></a></li>
                            <li><a class="fa fa-google-plus" href="#gplus"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div  class="col-xs-12 col-sm-6 col-lg-3  ">
                <div class="member-item">
                    <div class="image">
                        <img class="lazy" alt="" src="images/team-member-02.png" />
                    </div>
                    <div class="member-info">
                        <span class="name">Julia Doe</span><span class="devider">|</span><span class="position">ceo</span>
                        <p>
                            Cras porttitor sagittis ipsum, eu molestie tellus accumsan quis. Nam lectus nibh, lobortis sodales tempor vitae.
                        </p>
                        <ul class="list-inline member-socials">
                            <li><a class="fa fa-facebook" href="#fb"></a></li>
                            <li><a class="fa fa-twitter" href="#tw"></a></li>
                            <li><a class="fa fa-google-plus" href="#gplus"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div  class="col-xs-12 col-sm-6 col-lg-3  ">
                <div class="member-item">
                    <div class="image">
                        <img class="lazy" alt="" src="images/team-member-03.png" />
                    </div>
                    <div class="member-info">
                        <span class="name">Emin Diary</span><span class="devider">|</span><span class="position">developer</span>
                        <p>
                            Cras porttitor sagittis ipsum, eu molestie tellus accumsan quis. Nam lectus nibh, lobortis sodales tempor vitae.
                        </p>
                        <ul class="list-inline member-socials">
                            <li><a class="fa fa-facebook" href="#fb"></a></li>
                            <li><a class="fa fa-twitter" href="#tw"></a></li>
                            <li><a class="fa fa-google-plus" href="#gplus"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div  class="col-xs-12 col-sm-6 col-lg-3  ">
                <div class="member-item">
                    <div class="image">
                        <img class="lazy" alt="" src="images/team-member-04.png" />
                    </div>
                    <div class="member-info">
                        <span class="name">john doe</span><span class="devider">|</span><span class="position">delivery</span>
                        <p>
                            Cras porttitor sagittis ipsum, eu molestie tellus accumsan quis. Nam lectus nibh, lobortis sodales tempor vitae.
                        </p>
                        <ul class="list-inline member-socials">
                            <li><a class="fa fa-facebook" href="#fb"></a></li>
                            <li><a class="fa fa-twitter" href="#tw"></a></li>
                            <li><a class="fa fa-google-plus" href="#gplus"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="section-we-hire">
    <div class="container">

        <div class=" col-lg-offset-1 col-sm-7 col-lg-7">
            <div class="hire-body">
                <div class="title">
                    want to be a part of us? <strong>&nbsp;we are hiring!</strong>
                </div> 
                <p>
                    We have no specified needs, but present your ideas and yourself and we will contact you.
                </p>
            </div>
        </div>
        <div class="col-sm-5 col-lg-3 hire-button-holder">
            <a href="#" class="hire-button md-button large">join our team</a>
        </div>
    </div>
</section>

<section class="section-about-us-more">
    <div class="container">
        <div class="col-xs-12 col-sm-4">
            <div class="more-info-item">
                <h3>who we are</h3>
                <p>
                    Curabitur vulputate libero quis molestie imperdiet. Nulla libero nibh, scelerisque rutrum urna a, viverra cursus velit. Donec sodales elementum mattis. Integer a ligula dolor. Nam ornare purus in ante auctor, vitae sollicitudin lacus rhoncus. 
                </p>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4">
            <div class="more-info-item">
                <h3>what we do</h3>
                <p>
                    Curabitur vulputate libero quis molestie imperdiet. Nulla libero nibh, scelerisque rutrum urna a, viverra cursus velit. Donec sodales elementum mattis. Integer a ligula dolor. Nam ornare purus in ante auctor, vitae sollicitudin lacus rhoncus. 
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="more-info-item">
                <h3>our goal and idea</h3>
                <p>
                    Curabitur vulputate libero quis molestie imperdiet. Nulla libero nibh, scelerisque rutrum urna a, viverra cursus velit. Donec sodales elementum mattis. Integer a ligula dolor. Nam ornare purus in ante auctor, vitae sollicitudin lacus rhoncus. 
                </p>
            </div>
        </div>



    </div>
</section>

<section class="section-stats">
    <div class="container">
        <div class="col-xs-12 col-sm-3">
            <div class="stat-item">
                <span class="value">9431</span>
                <span class="title">sold products</span>
            </div>
        </div>

        <div class="col-xs-12 col-sm-3">
            <div class="stat-item">
                <span class="value">347</span>
                <span class="title">cups of coffee</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3">
            <div class="stat-item">
                <span class="value">21</span>
                <span class="title">product returns</span>
            </div>
        </div>

        <div class="col-xs-12 col-sm-3">
            <div class="stat-item">
                <span class="value">1094</span>
                <span class="title">satisfied clients</span>
            </div>
        </div>
    </div>
</section>

@endsection