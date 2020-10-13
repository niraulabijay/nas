<footer>
    <div class="footer wrapper-footer-newsletter">
        <div class="main-top-footer">
            <div class="container">
                <div class="row">
                    <aside class="col-sm-2 col-6  ">
                        <div class="textwidget">
                            <ul class="menu list-arrow">
                                <p class="ranasfot">About</p>
                                <li><a href="{{ route('contact.create') }}">Contact Us</a></li>
                                <li><a href="{{ route('aboutus') }}">About Us</a></li>
                                <li><a href="#">Careers</a></li>
                                <li><a href="{{ route('mission') }}">Mission & Vision</a></li>
                            </ul>
                        </div>
                    </aside>
                    <aside class="col-sm-2 col-6 ">
                        <div class="textwidget">
                            <ul class="menu list-arrow">
                                <p class="ranasfot">Help</p>
                                <li><a href="{{ route('payments') }}">Payments</a></li>
                                <li><a href="{{ route('shipping') }}">Shippings</a></li>
                                <li><a href="{{ route('cancellation') }}">Cancellation & Returns</a></li>
                                <li><a href="#">FAQ</a></li>
                            </ul>
                        </div>
                    </aside>
                    <aside class="col-sm-2 col-6 ">
                        <div class="textwidget">
                            <ul class="menu list-arrow">
                                <p class="ranasfot">Policy</p>
                                <li><a href="{{ route('return_policy') }}">Return Policy</a></li>
                                <li><a href="{{ route('terms_conditions') }}">Terms of Use</a></li>
                                <li><a href="{{ route('privacy_policy') }}">Privacy</a></li>
                                <li><a href="#">Sitemap</a></li>
                            </ul>
                        </div>
                    </aside>
                    <aside class="col-sm-2 col-6 custom-instagram ">
                        <div class="textwidget">
                            <ul class="menu list-arrow">
                                <p class="ranasfot">Social</p>
                                <li><a href="{{ getConfiguration('facebook_link') }}" target="_blank"><span class="fab fa-facebook"></span> Facebook</a></li>
                                <li><a href="{{ getConfiguration('instagram_link') }}" target="_blank"><span class="fab fa-instagram"></span> Instagram</a></li>
                                <li><a href="{{ getConfiguration('youtube_link') }}" target="_blank"><span class="fab fa-youtube"></span> Youtube</a></li>
                                <li><a href="{{ getConfiguration('twitter_link') }}" target="_blank"><span class="fab fa-twitter"></span> Twitter</a></li>
                            </ul>
                        </div>
                    </aside>
                    <aside class="col-sm-4 col-6 custom-instagram ">
                        <div class="textwidget">
                            <ul class="menu list-arrow">
                                <p class="ranasfot">Official Address</p>
                                <a href="#" class="meta-tags"><i class="fa fa-map-marker-alt"></i> {{ getConfiguration('site_address') }}</a><br>
                    <a href="mailto:{{ getConfiguration('site_primary_email') }}" class="meta-tags"><i class="fa fa-envelope"></i> {{ getConfiguration('site_primary_email') }}</a><br>
                    <a href="tel:{{ getConfiguration('site_primary_phone') }}" class="meta-tags"><i class="fa fa-mobile-alt"></i> {{ getConfiguration('site_primary_phone') }}</a>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

    </div>

</footer>
<div id="mini-footer">
    <div class="container ">
        {{-- <hr class="line"> --}}
        <div class="row relative">
            <div class="col-md-12 col-sm-6">
                
            </div>

            <div class="col-md-12 col-sm-12">  
                <div class="meta__tags">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Payment Methods</h5>
                            @foreach($payments as $payment)
                            <div class="payment" style="width: 70px;max-height: 70px;display: inline-block;">
                                <img src="{{ $payment->getImage()->mediumUrl }}" alt="{{ $payment->name }}">
                            </div>
                            @endforeach
                        </div>
                        <!--<div class="col-md-6">-->
                        <!--    <h5>Download Apps</h5>-->
                        <!--    <div style="width: 100px;max-height: 70px;display: inline-block;">-->
                        <!--        <a href="">-->
                        <!--            <img src="http://algorithm.wiki/en/app/assets/images/button/button_download_android.png" alt="" scale="0">-->
                        <!--        </a>-->
                        <!--    </div>-->
                        <!--    <div style="width: 100px;max-height: 70px;display: inline-block;">-->
                        <!--        <a href="">-->
                        <!--            <img src="https://membership.faithdirect.net/images/apple_store_badge.png" alt="" scale="0">-->
                        <!--        </a>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>