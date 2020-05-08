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
$comments = DB::table('Comment')->where('plantSubmissionId', '=', $submission->plantSubmissionId)->get();
$productDirectory = "img/".$submission->plantSubmissionId."/";
$images = array();
if (is_dir($productDirectory)) {
    $imageFiles = array_diff(scandir($productDirectory), array('.', '..'));
    foreach ($imageFiles as $image) {
        array_push($images, $productDirectory.$image);
    }

}

@endphp
<script>
            // Reply box popup JS
            $(document).ready(function(){
            $(".reply-popup").click(function(){
                $(".reply-box").toggle();
            });
            });
             
</script>
</br>
<div class="container">
    <div class="bg-white">
        
        <div class="row">
                <div class="col-2 content-center">
                        <form action='/submissions/{{$id}}/upvote' method='post'>
                                @csrf
                                <input type="image" name="submit" src="{{$userUpvoteImg}}" border="0" alt="Upvote" style="width: 50px;" /> ({{$submission->upvotes}})
                        </form> 
                </div>
                <div class="col-2"></div>
                <div class="col-12 text-center">
                    <h1>{{ $submission->title }} </h1>
                </div>
        </div>
        <div class="row d-flex justify-content-center align-items-center  border border-info rounded bg-success text-white" style="height:70px !important">
                    <p class="col-4">
                    Scientific Name: {{DB::table('Plant')->where('plantId', $submission['plantId'])->first()->species}} 
                    </p>
                    <p class="col-4">
                    Author: {{ DB::table('users')->where('userId', $submission['userId'])->first()->email   }}
                    </p>
                    <p class="col-3">
                    Creation Date: {{$submission->created_at->format("m/d/y")}}
                    </p>
        </div>
            
        <div class="mt-3 mb-3 d-flex justify-content-center align-items-center bg-success text-white border border-info rounded" style="height:100px !important"> 
                <p class="row">
                    {{$submission->description}} 
                </p>
        </div>
    </div>
    @if (sizeof($images) > 0) 
    <div class="row d-flex justify-content-center align-items-center  " style="height:200px !important;">
            
                 <img class="mx-auto" style="max-width:100%; max-height:100%;"  src="/{{$images[0]}}" alt="First slide">>
            
    </div>
    @endif
    </br>
    </br>
    </br>
            
    <div class="row text-center">
        <div class="col-12">
            @if (Auth::user() !== null && (Auth::user()->isAdmin() || Auth::user()->isMod() || Auth::id() === $submission->userId))
                <form action="/submissions/{{ $submission->plantSubmissionId }}" method="POST">
                    @csrf
                    <input type="hidden" name="userId" value="{{Auth::id()}}">
                    @method('DELETE')
                    <button class="btn btn-primary">Delete submission</button>
                </form>
            @endif
        </div>
    </div>        
    <div class="col-12 text-center">
	    <h4>Location of Submission</h4>
    </div> 
    <div id="map" style="height:200px"></div>
    <script>
        var mymap = L.map('map').setView([{{$submission->latitude}}, {{$submission->longitude}}], 5);
        var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
	}).addTo(mymap);
	var marker = L.marker([{{$submission->latitude}}, {{$submission->longitude}}]).addTo(mymap);
	marker.bindPopup("<b>Submission Location</b>");
    </script>
    <div class="row">
        <div class="col-12">
        <div class="comments">
            <div class="comments-details">
            <span class="total-comments comments-sort">{{sizeof($comments)}} Comments</span>  
            </div>
            <div class="comment-box add-comment">
                <span class="mx-10 my-10">
                    <form action="/comments" method="POST">
                        @csrf
                        <input name="plantSubmissionId" type="hidden" value="{{ $submission->plantSubmissionId }}" />
                        <input name="userId" type="hidden" value="{{Auth::id()}}" />
                        <input name="body" type="text" required />
                    
                    <button type="submit" class="btn btn-default">Comment</button>
                    <button type="cancel" class="btn btn-default">Cancel</button>
                    </form>
                </span>
            </div>

            @foreach ($comments as $comment)
                @if ($comment->parentId == 0)
                    <div class="comment-box">
                        <span class="mx-10 my-10">
                            <a href="#">{{DB::table('users')->where('userId', $comment->userId)->first()->email  }}</a> <span class="comment-time">{{$comment->created_at}}</span>
                        </span>       
                        <p class="comment-txt more">{{$comment->body}}</p>
                        <div class="comment-meta">
                            <button class="comment-reply reply-popup"><i class="fa fa-reply-all" aria-hidden="true"></i> Reply</button>
                            @if (Auth::user() !== null && (Auth::user()->isAdmin() || Auth::user()->isMod() || Auth::id() === $comment->userId))
                                <form action="/comments/{{$comment->commentId}}" method="POST">
                                        @csrf
                                        <input name="plantSubmissionId" type="hidden" value="{{ $submission->plantSubmissionId }}" />
                                        <input name="userId" type="hidden" value="{{Auth::id()}}" />
                                        <input name="parentId" type="hidden" value="{{$comment->commentId}}" />
                                        @method('DELETE')
                                        <button type="submit" class="comment-reply ">Delete</button>
                                </form>  
                            @endif       
                        </div>
                        <div class="comment-box add-comment reply-box">
                            
                            <span class="mx-10 my-10">
                                <form action="/comments" method="POST">
                                    @csrf
                                    <input name="plantSubmissionId" type="hidden" value="{{ $submission->plantSubmissionId }}" />
                                    <input name="userId" type="hidden" value="{{Auth::id()}}" />
                                    <input name="parentId" type="hidden" value="{{$comment->commentId}}" />
                                    <input name="body" type="text" required />
                                    <button type="submit" class="btn btn-default">Reply</button>
                                    <button type="cancel" class="btn btn-default reply-popup">Cancel</button>
                                </form>                    
                            </span> 
                        </div>
                    </div>
                @endif
                @php
                    $children = DB::table('Comment')->where('parentId', $comment->commentId)->get();
                @endphp
                @foreach ( $children as $child)
                    <div class="comment-box replied">
                        <span class="mx-10 my-10">
                            <a href="#">{{DB::table('users')->where('userId', $child->userId)->first()->email  }}</a> <span class="comment-time">{{$child->created_at}}</span>
                        </span>       
                        <p class="comment-txt more">{{$child->body}}</p>
                        <div class="comment-meta">
                            <button class="comment-reply reply-popup"><i class="fa fa-reply-all" aria-hidden="true"></i> Reply</button>
                            @if (Auth::user() !== null && (Auth::user()->isAdmin() || Auth::user()->isMod() || Auth::id() === $child->userId))
                                <form action="/comments/{{$child->commentId}}" method="POST">
                                        @csrf
                                        <input name="plantSubmissionId" type="hidden" value="{{ $submission->plantSubmissionId }}" />
                                        <input name="userId" type="hidden" value="{{Auth::id()}}" />
                                        <input name="parentId" type="hidden" value="{{$comment->commentId}}" />
                                        @method('DELETE')
                                        <button type="submit" class="comment-reply ">Delete</button>
                                </form>
                            @endif           
                        </div>
                        <div class="comment-box add-comment reply-box">
                            
                            <span class="mx-10 my-10">
                            <form action="/comments" method="POST">
                                @csrf
                                <input name="plantSubmissionId" type="hidden" value="{{ $submission->plantSubmissionId }}" />
                                <input name="userId" type="hidden" value="{{Auth::id()}}" />
                                <input name="parentId" type="hidden" value="{{$child->commentId}}" />
                                <input name="body" type="text" required/>
                                <button type="submit" class="btn btn-default">Reply</button>
                                <button type="cancel" class="btn btn-default reply-popup">Cancel</button>
                            </form>
                            </span>
                        </div>
                    </div>
                    

                @endforeach
            @endforeach

        </div>
    </div>


    </div>
    
</div>

@endsection
