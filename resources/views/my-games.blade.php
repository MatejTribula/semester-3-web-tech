@extends('layouts.app')

@section('title', 'My Games')

@section('content')

<div class="card add-game-card">
    <div class="card-img">
        <i class="fa-solid fa-plus"></i>
    </div>
    <div class="card-info">
        <h3>Add New Game</h3>
    </div>
</div>

<x-my-game-card title="test" image="#" />




        
@endsection
