@extends('layouts.estudiante')

@section('content')
<div class="container">
    <h1>Dashboard del Estudiante</h1>
    <p>Bienvenido, {{ Auth::user()->name }}.</p>
    <p>Tu rol es: {{ Auth::user()->role->nombre }}</p>
</div>
@endsection
