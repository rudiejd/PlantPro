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
    <div class="bg-light">
        
        <div class="row">
                <div class="col-2 content-center">
                        <form action='/submissions/{{$id}}/upvote' method='post'>
                                @csrf
                                <input type="image" name="submit" src="{{$userUpvoteImg}}" border="0" alt="Upvote" style="width: 50px;" /> ({{$submission->upvotes}})
                        </form> 
                </div>
                <div class="col-2"></div>
                <div class="col-4 text-center">
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
        </div>
    <div class="row">
        <div class="col-12">
        <div class="comments">
            <div class="comments-details">
            <span class="total-comments comments-sort">117 Comments</span>
            <span class="dropdown">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">Sort By <span class="caret"></span></button>
                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item">Top Comments</a>
                <a href="#" class="dropdown-item">Newest First</a>
                </div>
            </span>     
            </div>
            <div class="comment-box add-comment">
            <span class="mx-10 my-10">
                <input type="text" placeholder="Add a public comment" name="Add Comment">
                <button type="submit" class="btn btn-default">Comment</button>
                <button type="cancel" class="btn btn-default">Cancel</button>
            </span>
            </div>
            <div class="comment-box">
            <span class="mx-10 my-10">
                <a href="#">User</a> <span class="comment-time">2 hours ago</span>
            </span>       
            <p class="comment-txt more">Suspendisse massa enim, condimentum sit amet maximus quis, pulvinar sit amet ante. Fusce eleifend dui mi, blandit vehicula orci iaculis ac.</p>
            <div class="comment-meta">
                <button class="comment-like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 99</button>
                <button class="comment-dislike"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 149</button> 
                <button class="comment-reply reply-popup"><i class="fa fa-reply-all" aria-hidden="true"></i> Reply</button>         
            </div>
            <div class="comment-box add-comment reply-box">
                <span class="mx-10 my-10">
                <input type="text" placeholder="Add a public reply" name="Add Comment">
                <button type="submit" class="btn btn-default">Reply</button>
                <button type="cancel" class="btn btn-default reply-popup">Cancel</button>
                </span>
            </div>
            </div>
            <div class="comment-box">
            <span class="mx-10 my-10">
                <a href="#">User</a> <span class="comment-time">2 hours ago</span>
            </span>       
            <p class="comment-txt more">Suspendisse massa enim, condimentum sit amet maximus quis, pulvinar sit amet ante. Fusce eleifend dui mi, blandit vehicula orci iaculis ac.</p>
            <div class="comment-meta">
                <button class="comment-like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 99</button>
                <button class="comment-dislike"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 149</button> 
                <button class="comment-reply"><i class="fa fa-reply-all" aria-hidden="true"></i> Reply</button>         
            </div>
            <div class="comment-box replied">
                <span class="mx-10 my-10">
                    <a href="#">User</a> <span class="comment-time">2 hours ago</span>
                </span>       
                <p class="comment-txt more">Suspendisse massa enim, condimentum sit amet maximus quis, pulvinar sit amet ante. Fusce eleifend dui mi, blandit vehicula orci iaculis ac.</p>
                <div class="comment-meta">
                <button class="comment-like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 99</button>
                <button class="comment-dislike"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 149</button> 
                <button class="comment-reply"><i class="fa fa-reply-all" aria-hidden="true"></i> Reply</button>         
                </div>
                <div class="comment-box replied">
                <span class="mx-10 my-10">
                    <a href="#">User</a> <span class="comment-time">2 hours ago</span>
                </span>       
                <p class="comment-txt more">Suspendisse massa enim, condimentum sit amet maximus quis, pulvinar sit amet ante. Fusce eleifend dui mi, blandit vehicula orci iaculis ac.</p>
                <div class="comment-meta">
                    <button class="comment-like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 99</button>
                    <button class="comment-dislike"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 149</button> 
                    <button class="comment-reply"><i class="fa fa-reply-all" aria-hidden="true"></i> Reply</button>         
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>


    </div>
    
</div>

@endsection
