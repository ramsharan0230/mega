<!-- footer section starts -->

<footer class="all-sec-padding">
  <div class="container">
    <ul class="footer-menu">
      <li><a href="{{route('allExhibitionHalls')}}">Exhibition Hall</a></li>
      <li><a href="{{route('allExhibitors')}}">Exhibitors</a></li>
      <li><a href="{{route('allScholarships')}}">Scholarships</a></li>
      <li><a type="button" data-toggle="modal" data-target="#myModal">Guide Me</a></li>
      <li><a href="{{route('loginRegister')}}">Log In</a></li>
      <li><a href="{{route('loginRegister')}}">Register</a></li>
    </ul>
    <ul class="footer-media">
      <li><a target="_blank" href="{{$dashboard_composer->facebook}}"><i class="fa fa-facebook"
            aria-hidden="true"></i></a></li>
      <li><a target="_blank" href="{{$dashboard_composer->instagram}}"><i class="fa fa-instagram"
            aria-hidden="true"></i></a></li>
      <li><a target="_blank" href="{{$dashboard_composer->youtube}}"><i class="fa fa-youtube-play"
            aria-hidden="true"></i></a></li>
      <li><a target="_blank" href="{{$dashboard_composer->linkedin}}"><i class="fa fa-linkedin"
            aria-hidden="true"></i></a></li>
    </ul>
    <!--<a href="#" class="footer__support"><img src="/assets/front/img/unnamed.png">9803369899</a>-->
  </div>
</footer>
<section class="bg__primary">
  <div class="container">
    <p class="text-center text-md- text-white py-3">Design & Developed By:
      <a target="_blank" class="text-white" href="https://webhousenepal.com/">Web House
        Nepal</a>
    </p>
  </div>
</section>



<script src="/assets/front/js/jquery-3.5.1.min.js"></script>
<script src="/assets/front/js/bootstrap.bundle.min.js"></script>
<script src="/assets/front/js/slick.min.js"></script>
<script src="/assets/front/js/bootstrap-select.js"></script>
<script src="/assets/front/js/custom.js"></script>

<script type="text/javascript" id="cookieinfo" src="//cookieinfoscript.com/js/cookieinfo.min.js" data-bg="#374950"
  data-fg="#FFFFFF" data-link="#F1D600" data-cookie="CookieInfoScript" data-text-align="left" data-moreinfo="#"
  data-close-text="Got it!">
</script>
@stack('scripts')

</body>

</html>