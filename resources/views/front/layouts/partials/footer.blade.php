<!-- footer -->
<footer class="tst-white tst-fade-down">
	<div class="container">
		<div class="tst-footer-top">
			<!-- logo -->
			<a href="{{ route('front.home') }}">
				<img src="{{ asset('tastyc/img/infomar/logo-sin-slogan-blanco.png')}}" class="tst-logo d-none d-sm-block img-logo" alt="infomar">
				<img src="{{ asset('tastyc/img/infomar/logo-con-slogan-blanco.png')}}" class="tst-logo d-block d-sm-none img-logo" alt="infomar">
			</a>
			{{-- <img src="{{ asset('tastyc/img/logo_front.png')}}" class="tst-logo" alt="infomar"> --}}
			{{-- <div class="tst-social">
				<a href="#." class="tst-icon-link"><i class="far fa-circle"></i></a>
				<a href="#." class="tst-icon-link"><i class="far fa-circle"></i></a>
				<a href="#." class="tst-icon-link"><i class="far fa-circle"></i></a>
				<a href="#." class="tst-icon-link"><i class="far fa-circle"></i>/a>
			</div> --}}
		</div>
		<div class="tst-spacer tst-white"></div>
		<div class="row">
		<div class="col-lg-4">
			<div class="tst-mb-60">
			<h5 class="tst-mb-30 tst-text-shadow">Acerca de </h5>
			<div class="tst-text tst-text-shadow tst-mb-30">{{ Utiles::getSetting('slogan') }}</div>
			<a href="{{ route('front.about') }}" class="tst-label tst-color tst-anima-link">Leer más</a>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="tst-mb-60">
			<h5 class="tst-mb-30 tst-text-shadow">Contactos</h5>
			<ul class="tst-footer-contact tst-text-shadow tst-mb-30">
				<li><span class="tst-label">Teléfono :</span><span class="tst-text">{{ Utiles::getSetting('telefono') }}</span></li>
				<li><span class="tst-label">Email :</span><span class="tst-text">{{ Utiles::getSetting('email') }}</span></li>
				<li><span class="tst-label">Dirección :</span><span class="tst-text">{{ Utiles::getSetting('direccion') }}</span></li>
			</ul>
			<a href="contact.html" class="tst-label tst-color tst-anima-link">Leer más</a>
			</div>
		</div>
		{{-- <div class="col-lg-4">
			<div class="tst-mb-60">
			<h5 class="tst-mb-30 tst-text-shadow">Gallery</h5>
			<div class="swiper-container tst-footer-gallery">
				<div class="swiper-wrapper tst-cursor-zoom">
				<div class="swiper-slide">
					<div class="tst-footer-gal-item">
					<img src="{{ asset('tastyc/img/menu/1.jpg')}}" alt="gallery item">
					<a data-fancybox="gal" href="{{ asset('tastyc/img/menu/1.jpg') }}" class="tst-overlay">
						<i class="fas fa-search-plus"></i>
					</a>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="tst-footer-gal-item">
					<img src="{{ asset('tastyc/img/menu/2.jpg')}}" alt="gallery item">
					<a data-fancybox="gal" href="{{ asset('tastyc/img/menu/2.jpg') }}" class="tst-overlay">
						<i class="fas fa-search-plus"></i>
					</a>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="tst-footer-gal-item">
					<img src="{{ asset('tastyc/img/menu/3.jpg')}}" alt="gallery item">
					<a data-fancybox="gal" href="{{ asset('tastyc/img/menu/3.jpg') }}" class="tst-overlay">
						<i class="fas fa-search-plus"></i>
					</a>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="tst-footer-gal-item">
					<img src="{{ asset('tastyc/img/menu/4.jpg')}}" alt="gallery item">
					<a data-fancybox="gal" href="{{ asset('tastyc/img/menu/4.jpg') }}" class="tst-overlay">
						<i class="fas fa-search-plus"></i>
					</a>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="tst-footer-gal-item">
					<img src="{{ asset('tastyc/img/menu/5.jpg')}}" alt="gallery item">
					<a data-fancybox="gal" href="{{ asset('tastyc/img/menu/5.jpg') }}" class="tst-overlay">
						<i class="fas fa-search-plus"></i>
					</a>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="tst-footer-gal-item">
					<img src="{{ asset('tastyc/img/menu/6.jpg')}}" alt="gallery item">
					<a data-fancybox="gal" href="{{ asset('tastyc/img/menu/6.jpg') }}" class="tst-overlay">
						<i class="fas fa-search-plus"></i>
					</a>
					</div>
				</div>
				</div>
				<div class="tst-gallery-nav">
				<a href="about-us.html" class="tst-label tst-color tst-anima-link">See more</a>
				<div class="tst-fg-nav">
					<div class="tst-slider-btn tst-fg-prev"><i class="fas fa-arrow-left"></i></div>
					<div class="tst-slider-btn tst-fg-next"><i class="fas fa-arrow-right"></i></div>
				</div>
				</div>
			</div>
			</div>
		</div> --}}
		</div>
		<div class="tst-spacer tst-white tst-spacer-only-bottom-space"></div>
		<div class="tst-footer-bottom">
		<div class="tst-text">Copyright © 2022 Todos los derechos reservados.</div>
		<a href="#tst-app" class="tst-label tst-color tst-anchor-scroll">Volver arriba</a>
		</div>
	</div>
	</footer>
	<!-- footer end -->