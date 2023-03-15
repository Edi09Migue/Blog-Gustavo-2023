@extends('front.layouts.plantilla')

@section('title','Inicio')
@section('description', 'Gustavo Ibarra comunicador político')

@section('contenido')
   @include('front.pages.home.about')
   <hr class="le-hr">
   @include('front.pages.home.academia')
   <hr class="le-hr">
   @include('front.pages.home.articulos')
   <hr class="le-hr">
   @include('front.pages.home.contacto')
@endsection