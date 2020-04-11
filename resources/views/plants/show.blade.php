@extends('layouts.layout')
@section('content')


<div class="content text-center">
    @if (isset($plant))
        <h1>{{ $plant['commonName']}}</h1>

        <form></form>

        <form action="/plants/{{ $plant['plantId'] }}" method="POST">
            @csrf
            @method('DELETE')
            <button>Delete plant</button>
        </form>




    @else
        <h1> Plant not found </h1>
    @endif

</div>
</body>
@endsection
