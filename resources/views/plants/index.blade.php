@extends('layouts.layout')
@section('content')


    <div class="content text-center">
        <h1>All Plants</h1>
        <h4><a href="/plants/create/">(Add Plant)</a></h4>
        @foreach($plants as $plant)
            <div><a href="/plants/{{ $plant->plantId }}"><i>{{$plant->genus}} {{$plant->species}} </i>({{ $plant->commonName }})</a> </div>
        @endforeach
    </div>
</body>
@endsection
