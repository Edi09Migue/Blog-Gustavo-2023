
	<!-- top bar frame -->
	<div class="tst-menu-frame">
		<!-- top bar -->
		<div class="tst-dynamic-menu" id="tst-dynamic-menu">
		<div class="tst-menu tst-onepage">
			<!-- logo -->
			<a href="{{ route('front.home') }}">
				<img src="{{ asset('tastyc/img/infomar/logo-sin-slogan.png')}}" class="tst-logo d-none d-sm-block img-logo" alt="infomar">
				<img src="{{ asset('tastyc/img/infomar/logo-con-slogan.png')}}" class="tst-logo d-block d-sm-none img-logo" alt="infomar">
			</a>
			<!-- menu -->
			<nav>
				<ul>
					<li class="@if($control_menu == 'home') current-menu-item @endif"><a data-no-swup href="{{ route('front.home') }}">Inicio</a></li>
					<li class="@if($control_menu == 'about') current-menu-item @endif"><a data-no-swup href="{{ route('front.about') }}">Acerca de</a></li>
					<li class="@if($control_menu == 'recetas') current-menu-item @endif"><a data-no-swup href="{{ route('front.recetas') }}">Recetas</a></li>
					<li class="@if($control_menu == 'especies') current-menu-item @endif"><a data-no-swup href="{{ route('front.especies') }}">Especies</a></li>
					<li class="@if($control_menu == 'blog') current-menu-item @endif"><a data-no-swup href="{{ route('front.noticias') }}">Noticias</a></li>
					<li class="@if($control_menu == 'contacto') current-menu-item @endif"><a data-no-swup href={{ route('front.contacto')}}>Contacto</a></li>
				</ul>
			</nav>
			<!-- menu end -->
			<!-- top bar right -->
			<div class="tst-menu-right">
			<!-- menu button -->
			<div class="tst-menu-button-frame">
				<div class="tst-menu-btn">
				<div class="tst-burger">
					<span></span>
				</div>
				</div>
			</div>
			<!-- menu button end -->
			</div>
			<!-- top bar right end  -->
		</div>
		</div>
		<!-- top bar end -->
	</div>
	<!-- top bar frame -->
