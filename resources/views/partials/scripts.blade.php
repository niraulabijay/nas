{{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
{{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}

<!-- UIkit JS -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.16/js/uikit.min.js"></script> --}}

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.16/js/uikit-icons.min.js"></script> --}}
<!-- Owl carousel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<!-- metis menu -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.8/metisMenu.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

<!-- custom scroll -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>


<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('magnific-popup/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset('backend/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

{{--Algolia--}}
<script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
<script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.9/metisMenu.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>


<script src="{{ asset('front/js/hammer.min.js') }}"></script>
<script src="{{ asset('front/js/zoom.js') }}"></script>
<script src="{{ asset('front/js/app.min.js') }}"></script>
{{-- <script src="{{ asset('front/js/setup.js') }}"></script> --}}
<script src="{{asset('front/js/singlepage.js') }}"></script>

<script>
    $(document).ready(function() {
  $('.hide--onpageload').removeClass('hide--onpageload');
  
        $('.brand__filter label:lt(5)').css('display','block');
        $('.color__filter label:lt(5)').css('display','block');
        $('.size__filter label:lt(5)').css('display','block');
        
        $(document).on('click', '.more-filter', function () {
                $this = $(this);
                $this.siblings('label').css('display','block');
                $this.css('display','none');
                 $this.siblings('.less-filter').css('display','block');
        
        });
        
        $(document).on('click', '.less-filter', function () {
                $this = $(this);
                $this.siblings('label').css('display','none');
                $this.siblings('label:lt(5)').css('display','block');
                $this.css('display','none');
                 $this.siblings('.more-filter').css('display','block');
        
        });
        
//         $(".nav-category > li").mouseover(function(){
//             $(this).children('a').addClass('uk-open');
//             $(this).children('.uk-dropdown').addClass('uk-open');
//         });

// 		$(".nav-category > li").mouseleave(function(){
// 			$(this).children('a').removeClass('uk-open');
//             $(this).children('.uk-dropdown').removeClass('uk-open');
// 		 });
});
</script>


