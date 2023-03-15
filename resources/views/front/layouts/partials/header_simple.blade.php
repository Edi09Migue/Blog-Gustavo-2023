<header id="home">

	<div class="bg-image" data-bg-image="{{ asset('blog/images/head-image-4.jpg') }}" style="background-position: center center; background-image: url(&quot;blog/images/head-image-4.jpg&quot;); background-size: cover; background-repeat: no-repeat; height: 535px;">
		
	</div>

	

	<div class="col-xs-12  nav-menu top-menu-holder">
	  <nav class="hidden-xs visible-lg ">
		<ul class="nav">
			<li class="">
			<a href="{{ route('front.home')}}" address="true">COMPOL</a>
		  </li>
		  <li class="">
			<a href="#info" address="true">SOBRE GUSTAVO</a>
		  </li>
		  <li class="">
			<a href="{{ route('front.home')}}#education" address="true">Vida Académica</a>
		  </li>
		  <li class="active">
			<a href="#blog" address="true">Artículos</a>
		  </li>
		  <li>
			<a href="#contact" address="true">Contacto</a>
		  </li>


		</ul>

	  </nav>

	  <select class="top-drop-menu nav visible-md visible-sm visible-xs hidden-lg">
		<option value="#home" selected="selected">
		  Home
		</option>

		<option value="#profile">
		  Profile
		</option>
		<option value="#education">
		  Education
		</option>
		<option value="#experiences">
		  Experiences
		</option>

		<option value="#skills">
		  Skills
		</option>

		<option value="#portfolio">
		  Portfolio
		</option>

		<option value="#contact">
		  Contact
		</option>

	  </select>
	</div>

  </header>