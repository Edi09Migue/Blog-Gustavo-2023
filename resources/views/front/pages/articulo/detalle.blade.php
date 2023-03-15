<section id="single-post-01" class="single-post" >
  <div class="sticky-paper-head has-shadow">
    <div class="content ">
      <h1>Artículo</h1>
    </div>    
  </div>


  <div class="sticky-paper-body has-shadow " >
    <div class="content">
        <div class="single-post">
  
          <div class="post-image">
            <h1>{{$articulo->titulo}}</h1>
              <div class="short-desc">
                {{$articulo->fechaFormated}}
            </div>    
            <img alt="" src="{{$articulo->imagenURL}}" />
          </div>
        
          <div class="content" style="text-align: justify; margin-top: 30px">
            <p>
              {!!$articulo->contenido!!}
            </p>
          </div>

       
        </div>
    </div>
  </div>
</section>