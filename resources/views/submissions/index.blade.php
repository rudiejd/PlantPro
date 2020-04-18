@extends('layouts.layout')
@section('content')


<div class="content text-center">
    <h1>Latest submissions</h1>
    <h4><a href="/submissions/create">(Submit Sighting)</a></h4>
    @foreach($submissions as $submission)
        <div> <h2> <a href='/submissions/{{$submission->plantSubmissionId}}'>{{ $submission->title}} </h2> </div>
    @endforeach
    
</div>
</body>
@endsection
