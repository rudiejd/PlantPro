@extends('layouts.layout')
@section('content')


<div class="content text-center">
    <h1>All Submissions for <i> {{ DB::table('Plant')->where('plantId', $id)->first()->genus }} {{ DB::table('Plant')->where('plantId', $id)->first()->species }}</i> ({{DB::table('Plant')->where('plantId', $id)->first()->commonName}})   </h1>
    @foreach ($submissions as $submission )
        <div>User: {{ DB::table('users')->where('userId', $submission['userId'])->first()->email    }} Plant: {{$submission->plantId}} </br>Description: {{$submission->description}} :  </div>
    @endforeach
</div>

</body>
@endsection
