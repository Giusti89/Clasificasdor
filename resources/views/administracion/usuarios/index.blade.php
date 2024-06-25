@extends('layouts.base')
@section('titulo', 'usuarios')
@section('nombre','Administracion de Usuarios')

@section('contenido')
   @livewire('tabla-usuarios')

@endsection