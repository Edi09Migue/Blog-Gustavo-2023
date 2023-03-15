<section id="blog">
  <div class="sticky-paper-head has-shadow ">
    <div class="content">
      <h1>Artículos</h1>
    </div>
  <div class="shadow"></div></div>
  

  <div class="sticky-paper-body has-shadow ">
    <div class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="blog-list-holder row">

            @foreach ($articulos as $articulo)
              <div class="blog-item item col-xs-12 col-md-6 col-lg-4">
                <div class="thumb has-shadow">
                  <div class="date">
                  {{$articulo->fechaFormated}}
                </div> 
                  <img alt="" src="{{$articulo->imagenURL}}">
                <div class="shadow"></div></div>
                <div class="info-area">
                  <div class="title">
                    <a href="{{ route('front.articulo', $articulo->slug)}}">
                      {{$articulo->titulo}}
                    </a>
                  </div>
                  <div class="excerpt">
                    <p>
                      {!!substr($articulo->contenido, 0, 160)!!}...
                    </p>
                  </div>
                  <a class="le-btn" href="single-post.html">Leer más</a>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  <div class="shadow"></div></div>
</section>