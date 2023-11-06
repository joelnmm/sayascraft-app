@extends('layouts.base')
@section('content')
<head>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<style>
  .btn{
    position: absolute;
    right: 0;
    top: 0;
    font-size:34px;
    margin-right: -10px;
    margin-top: -15px;
  }
  dialog::backdrop {
    background: rgba(0, 70, 0, 0.5);
  }
</style>

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero" >

  <!-- start container for ad -->
  <dialog id='dialog' onclick='closeDialog()'>
    <a type="button" class="btn" aria-label="Close" onclick='closeDialog()'><i class="fa fa-window-close"></i></a>
    <img src='assets/img/ad_1.png' width='728' height='90' alt=''>
  </dialog>
  <!-- end container for ad -->

    <div class="container position-relative">
      <div class="row gy-5" data-aos="fade-in">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">
          <h2>Handmade Crafts, Custom Bracelets <br> & More<span> </span></h2>
          <p>Explore our variety of Handmade Crafts or get your own handmade custom bracelet, pick your favorite colors and capture your name or favorite phrase on it!</p>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <a href="/create-bracelet" class="btn-get-started" >Create your bracelet</a>
            <!-- <a href="url-to-video" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-bag-fill"></i><span>Watch video</span></a> -->
            <a href="/products" class="btn-watch-video d-flex align-items-center"><i class="bi bi-bag-fill"></i><span>Shop Our Crafts</span></a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2">
          <img src="assets/img/cover_kids.png" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="100">
        </div>
      </div>
    </div>

    <div class="icon-boxes position-relative">
      <div class="container position-relative">
        <div class="row gy-4 mt-5">

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="icon-box" style="background-color:#ffffff;">
              <div class="icon" style="color:rgb(28 23 23 / 60%);"><i class="bi bi-easel"></i></div>
              <h4 class="title"><a class="stretched-link" style="color: #444343;">Ecuadorian Handmade Crafts</a></h4>
            </div>
          </div>
          <!--End Icon Box -->

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="icon-box" style="background-color:#ffffff;">
              <div class="icon" style="color:rgb(28 23 23 / 60%);"><i class="bi bi-gem"></i></div>
              <h4 class="title"><a class="stretched-link" style="color: #444343;">Unique design just like you</a></h4>
            </div>
          </div>
          <!--End Icon Box -->

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="icon-box" style="background-color:#ffffff;">
              <div class="icon" style="color:rgb(28 23 23 / 60%);"><i class="bi bi-geo-alt"></i></div>
              <h4 class="title"><a class="stretched-link" style="color: #444343;">Shipping in all the U.S.</a></h4>
            </div>
          </div>
          <!--End Icon Box -->

          <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="icon-box" style="background-color:#ffffff;">
              <div class="icon" style="color:rgb(28 23 23 / 60%);"><i class="bi bi-heart"></i></div>
              <h4 class="title"><a class="stretched-link" style="color: #444343;">Handmade with love</a></h4>
            </div>
          </div>
          <!--End Icon Box -->

        </div>
      </div>
    </div>

    </div>
  </section>
  <!-- End Hero Section -->

  <main id="main">

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>About Us</h2>
          <p>Step into the vibrant world of the Males family, a group of talented crafters hailing from the picturesque highlands of Ecuador. With their hands and hearts intricately woven into the fabric of their culture, this family's artistry shines through in every meticulously crafted piece they offer. Each product tells a unique story, a reflection of their rich heritage, and a testament to their unwavering dedication to preserving traditional craftsmanship.</p>
          <!-- <p>We are Ecuadorian people who are trying to bring some of our interesting culture to the USA and the whole world!</p> -->
        </div>

        <div class="row gy-4">
          <div class="col-lg-6">
            <h3>Explore our variety of crafted designs that we have for you</h3>
            <img src="/assets/img/carousel_1.png" class="img-fluid rounded-4 mb-4">
            <p>From the colorful Andean textiles that burst with indigenous patterns and symbolism to the outstanding handmade bracelets, our products come in a wide variety of styles, so you're sure to find something that suits your taste. Shop our collection today and add a touch of artisanal charm to your everyday style!</p>
          </div>
          <div class="col-lg-6">
            <div class="content ps-0 ps-lg-5">
              <p class="fst-italic">
                We love to keep our tradition taught from our parents and grandparents, so these are some interesting facts about
                our friendship bracelets:
              </p>
              <br>
              <ul>
                <li><i class="bi bi-check-circle-fill"></i> They are 100% handmade from Ecuadorian people.</li>
                <li><i class="bi bi-check-circle-fill"></i> We started selling our bracelets in the streets of Manhattan since 2016.</li>
                <li><i class="bi bi-check-circle-fill"></i> Handcrafted bracelets made with premium materials that will last you for at least 5 years.</li>
                <li><i class="bi bi-check-circle-fill"></i> Unique designs that you won't find anywhere else.</li>
              </ul>
              <img src="/assets/img/bracelets-examples/friendship_bracelets.png" class="img-fluid rounded-4 mb-4" style="width:100%;">
            </div>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Clients Section ======= -->
    <!-- <section id="clients" class="clients">
      <div class="container" data-aos="zoom-out">

        <div class="clients-slider swiper">
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide"><img src="assets/img/clients/client-1.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-2.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-3.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-4.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-5.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-6.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-7.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-8.png" class="img-fluid" alt=""></div>
          </div>
        </div>

      </div>
    </section> -->
    <!-- End Clients Section -->

    <!-- ======= Stats Counter Section ======= -->
    <section id="stats-counter" class="stats-counter">
      <div class="container" data-aos="fade-up">

        <div class="row gy-4 align-items-center">

          <div class="col-lg-6">
            <img src="assets/img/stats-img.svg" alt="" class="img-fluid">
          </div>

          <div class="col-lg-6">

            <div class="stats-item d-flex align-items-center">
              <span data-purecounter-start="0" data-purecounter-end="102" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Happy Clients</strong> with satisfied products</p>
            </div><!-- End Stats Item -->

            <div class="stats-item d-flex align-items-center">
              <span data-purecounter-start="0" data-purecounter-end="178" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Bracelets</strong> sold by our company</p>
            </div><!-- End Stats Item -->

            <div class="stats-item d-flex align-items-center">
              <span data-purecounter-start="0" data-purecounter-end="453" data-purecounter-duration="1" class="purecounter"></span>
              <p><strong>Hours Of Support</strong> aut commodi quaerat</p>
            </div>
            <!-- End Stats Item -->

          </div>

        </div>

      </div>
    </section><!-- End Stats Counter Section -->

    <!-- ======= Call To Action Section ======= -->
    <!-- <section id="call-to-action" class="call-to-action">
      <div class="container text-center" data-aos="zoom-out">
        <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn"></a>
        <h3>Call To Action</h3>
        <p> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <a class="cta-btn" href="#">Call To Action</a>
      </div>
    </section> -->
    <!-- End Call To Action Section -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio sections-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Products</h2>
          <p>Handcrafted textiles for you to pick. Explore our variety of designs and choose the one that matches your style.</p>
        </div>

        <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order" data-aos="fade-up" data-aos-delay="100">

          <div>
            <ul class="portfolio-flters">
              <li data-filter="" class="filter-active"><a href="/products" style="color: black;">All products → </a></li>
              <!-- <li data-filter=".filter-app">App</li>
              <li data-filter=".filter-product">Product</li>
              <li data-filter=".filter-branding">Branding</li>
              <li data-filter=".filter-books">Books</li> -->
            </ul>
            <!-- End Portfolio Filters -->
          </div>

          <div class="row gy-4 portfolio-container">

            <div class="col-xl-4 col-md-6 portfolio-item filter-app">
              <div class="portfolio-wrap">
                <a href="/assets/img/portfolio/1.JPG" data-gallery="portfolio-gallery-app" class="glightbox"><img src="/assets/img/portfolio/1.JPG" class="img-fluid" alt=""></a>
                <div class="portfolio-info">
                  <h4><a href="#" title="More Details">Kids Poncho</a></h4>
                  <p>Andes pattern poncho</p>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-xl-4 col-md-6 portfolio-item filter-product">
              <div class="portfolio-wrap">
                <a href="/assets/img/portfolio/2.JPG" data-gallery="portfolio-gallery-app" class="glightbox"><img src="/assets/img/portfolio/2.JPG" class="img-fluid" alt=""></a>
                <div class="portfolio-info">
                  <h4><a href="#" title="More Details">kids Overall</a></h4>
                  <p>Bright pattern overall</p>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-xl-4 col-md-6 portfolio-item filter-branding">
              <div class="portfolio-wrap">
                <a href="/assets/img/portfolio/3.JPG" data-gallery="portfolio-gallery-app" class="glightbox"><img src="/assets/img/portfolio/3.JPG" class="img-fluid" alt=""></a>
                <div class="portfolio-info">
                  <h4><a href="#" title="More Details">Kids Poncho</a></h4>
                  <p>One way poncho</p>
                </div>
              </div>
            </div><!-- End Portfolio Item -->
      <!-- next line -->
            <div class="col-xl-4 col-md-6 portfolio-item filter-books">
              <div class="portfolio-wrap">
                <a href="/assets/img/portfolio/5.JPG" data-gallery="portfolio-gallery-app" class="glightbox"><img src="/assets/img/portfolio/5.JPG" class="img-fluid" alt=""></a>
                <div class="portfolio-info">
                  <h4><a href="#" title="More Details">Kids Poncho</a></h4>
                  <p>Dark/bright andes pattern poncho</p>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-xl-4 col-md-6 portfolio-item filter-app">
              <div class="portfolio-wrap">
                <a href="/assets/img/portfolio/8.JPG" data-gallery="portfolio-gallery-app" class="glightbox"><img src="/assets/img/portfolio/8.JPG" class="img-fluid" alt=""></a>
                <div class="portfolio-info">
                  <h4><a href="#" title="More Details">Kids Poncho</a></h4>
                  <p>Andes mix pattern poncho</p>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

            <div class="col-xl-4 col-md-6 portfolio-item filter-product">
              <div class="portfolio-wrap">
                <a href="/assets/img/portfolio/7.JPG" data-gallery="portfolio-gallery-app" class="glightbox"><img src="/assets/img/portfolio/7.JPG" class="img-fluid" alt=""></a>
                <div class="portfolio-info">
                  <h4><a href="#" title="More Details">Kids Overall</a></h4>
                  <p>Blue spirit overall</p>
                </div>
              </div>
            </div><!-- End Portfolio Item -->

          </div><!-- End Portfolio Container -->

        </div>

      </div>
    </section>
    <!-- End Portfolio Section -->

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq sections-bg">
      <div class="container" data-aos="fade-up">

        <div class="row gy-4">

          <div class="col-lg-4">
            <div class="content px-xl-5">
              <h3>Frequently Asked <strong>Questions</strong></h3>
              <p>
                These are some of the most asked questions by our customers. We hope we can clarify your doubts.
              </p>
            </div>
          </div>

          <div class="col-lg-8">

            <div class="accordion accordion-flush" id="faqlist" data-aos="fade-up" data-aos-delay="100">

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-1">
                    <span class="num">1.</span>
                    How long does the bracelets last?
                  </button>
                </h3>
                <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                  <div class="accordion-body">
                    Like any product it will last as much as you take care of it, but, in average it will last you for at least 5 years.
                  </div>
                </div>
              </div><!-- # Faq item-->

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-2">
                    <span class="num">2.</span>
                    How long does it take to ship my product?
                  </button>
                </h3>
                <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                  <div class="accordion-body">
                    We normally ship your product the next bussiness day after we verify the transaction is correctly made, then your product will be delivered to you within 2-5 days. You will receive instantly a confirmation order mail after you make a purchase. Once your order is shipped, you'll receive another email with the tracking information.
                  </div>
                </div>
              </div><!-- # Faq item-->

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-3">
                    <span class="num">3.</span>
                    Are the bracelets adjustable or one size?
                  </button>
                </h3>
                <div id="faq-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                  <div class="accordion-body">
                    All of our bracelets are adjustable, if you buy a custom bracelet on the create section, the size of this bracelet will also be adjustable, the size is just to have a reference of your wrist.
                  </div>
                </div>
              </div><!-- # Faq item-->

              <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-4">
                    <span class="num">4.</span>
                    Can I return a product?
                  </button>
                </h3>
                <div id="faq-content-4" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                  <div class="accordion-body">
                    Since we are still a small growing company, we are not supporting returns yet, we will in the future but our sales are final for now, this is also stipulated in the <a href="/terms-and-conditions" target="_blank"> Terms and Conditions</a> page
                  </div>
                </div>
              </div><!-- # Faq item-->

              <!-- <div class="accordion-item">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-5">
                    <span class="num">5.</span>
                    Tempus quam pellentesque nec nam aliquam sem et tortor consequat?
                  </button>
                </h3>
                <div id="faq-content-5" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                  <div class="accordion-body">
                    Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in
                  </div>
                </div>
              </div> -->
              <!-- # Faq item-->

            </div>

          </div>
        </div>

      </div>
    </section><!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Contact</h2>
          <p>If you have any questions or doubts, please feel free to contact us and we will get in touch with you as soon as possible.</p>
        </div>

        <div class="row gx-lg-0 gy-4" style="display: flex;justify-content: center;">

          <div class="col-lg-8">
            <form method="POST" action="{{url('send-contact-info')}}" role="form">
            @csrf
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="7" placeholder="Message" required></textarea>
              </div>
              @if(Session::has('success_message'))
                <div class="alert alert-danger" style="margin-top:10px;" role="alert">{{Session::get('success_message')}}</div>
              @endif
              <div class="text-center"><button style="margin-top:20px; border:none; background-color:black; color:white; border-radius:5px" type="submit">Send Message</button></div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

<script>

  const myDialog = document.getElementById('dialog');
  var showAd = <?php echo json_encode($showAd) ?>;

  $(document).ready(function(){
    if(showAd == 'true'){
      myDialog.showModal();
    }
  });

  function closeDialog(){
    myDialog.close();
  }

</script>

@endsection

 