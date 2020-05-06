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
        <div class="row text-center">
                <div class="col-4">
                    Plant: {{DB::table('Plant')->where('plantId', $submission['plantId'])->first()->commonName}} 
                </div>
                <div class="col-4">
                    Author: {{ DB::table('users')->where('userId', $submission['userId'])->first()->email   }}
                </div>
                <div class="col-4">
                    {{$submission->created_at->format("m/d/y")}}
                </div>
        </div>
            
        <div class="text-muted content-center text-center">
            {{$submission->description}}
            @if (sizeof($images) > 0) 
                </br>
                <div id="carouselControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" style="width:100%; height: 500px !important;"> 
                    <div class="carousel-item active">
                        <a src="/{{$images[0]}}">
                            <img class="d-block w-100" src="/{{$images[0]}}" alt="First slide">
                        </a>
                    </div>
                    @for ($counter = 1; $counter < sizeof($images); $counter++)
                        <div class="carousel-item">
                                <a href="/{{ $images[counter] }}">
                                    <img class="d-block w-100" src="/{{ $images[counter] }}" alt="Image">
                                </a>
                            </div>
                    @endfor
                </div>
            @endif
            <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
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
                            <button class="comment-like" type="submit">{{$comment->upvotes}}</button>
                            <button class="comment-reply reply-popup"><i class="fa fa-reply-all" aria-hidden="true"></i> Reply</button>         
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
                            <button class="comment-like">{{$child->upvotes}}</button>
                            <button class="comment-reply reply-popup"><i class="fa fa-reply-all" aria-hidden="true"></i> Reply</button>         
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
