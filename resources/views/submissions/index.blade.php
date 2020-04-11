@extends('layouts.layout')
@section('content')


<div class="content text-center">
    <h1>Latest submissions</h1>
    <h4><a href="/submissions/create">(Submit Sighting)</a></h4>
    @foreach($submissions as $submission)
        <div> Posted by {{$submission->userId}}: </br> {{ $submission->title}} : {{$submission->description}} </div>
    @endforeach
    
</div>
</body>
@endsection
