@extends('layouts.layout')
@section('content')
@php
use App\PlantSubmission;
// checking whether user has upvote the post so we can decide which upvote image to display

$hasUpvoted = DB::select('SELECT EXISTS ( SELECT NULL FROM UserUpvotes WHERE userId = :uid AND plantSubmissionId = :pid ) AS res', ['uid' => Auth::id(), 'pid' => $id])[0];
$userUpvoteImg;

if ($hasUpvoted->res == 1) {
    $userUpvoteImg = '../../img/upvoted.jpg';
}
else {
    $userUpvoteImg = '../../img/upvote.jpg';
}
$submission = PlantSubmission::findOrFail($id);

@endphp

<div class="text-center">
    <span>
        <span class="d-inline-flex">
        <h1>{{ $submission->title }} </h1>
            
                <form action='/submissions/{{$id}}/upvote' method='post' class="col-3">
                    @csrf
                    <input type="image" name="submit" src="{{$userUpvoteImg}}" border="0" alt="Upvote" style="width: 50px;" /> ({{$submission->upvotes}})
                </form> 
        </span>
            <h3> Plant: {{DB::table('Plant')->where('plantId', $submission['plantId'])->first()->commonName}} </br>Submitted by: {{ DB::table('users')->where('userId', $submission['userId'])->first()->email   }}</br> {{$submission->created_at}}</br>Description: {{$submission->description}}</h3>
    
</div>

</body>
@endsection
