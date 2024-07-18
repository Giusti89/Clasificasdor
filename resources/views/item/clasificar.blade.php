@extends('layouts.clasi')
@section('titulo', 'Clasifiador')


@section('contenido')
    @livewire('tabla-clasificador', ['identificador' => $encryptedId])

@endsection
