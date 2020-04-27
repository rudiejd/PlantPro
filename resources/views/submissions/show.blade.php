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
$comments = DB::table('Comment')->where('plantSubmissionId', '=', 1)->get();

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
                    <form action="/comments" method="POST">
                        @csrf
                        <input name="plantSubmissionId" type="hidden" value="{{ $submission->plantSubmissionId }}" />
                        <input name="userId" type="hidden" value="{{Auth::id()}}" />
                        <input name="body" type="text" />
                    
                    <button type="submit" class="btn btn-default">Comment</button>
                    <button type="cancel" class="btn btn-default">Cancel</button>
                    </form>
                </span>
            </div>

            @foreach ($comments as $comment)
                <div class="comment-box">
                    <span class="mx-10 my-10">
                        <a href="#">{{DB::table('users')->where('userId', $comment->userId)->first()->email  }}</a> <span class="comment-time">{{$comment->created_at}}</span>
                    </span>       
                    <p class="comment-txt more">{{$comment->body}}</p>
                    <div class="comment-meta">
                        <button class="comment-like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 99</button>
                        <button class="comment-dislike"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 149</button> 
                        <button class="comment-reply reply-popup"><i class="fa fa-reply-all" aria-hidden="true"></i> Reply</button>         
                    </div>
                    <div class="comment-box add-comment reply-box">
                        
                        <span class="mx-10 my-10">
                        <form action="/comments" method="POST">
                            @csrf
                            <input name="plantSubmissionId" type="hidden" value="{{ $submission->plantSubmissionId }}" />
                            <input name="userId" type="hidden" value="{{Auth::id()}}" />
                            <input name="parentId" type="hidden" value="{{$comment->commentId}}" />
                            <input name="body" type="text" />
                            <button type="submit" class="btn btn-default">Reply</button>
                            <button type="cancel" class="btn btn-default reply-popup">Cancel</button>
                        </form>
                        </span>
                    </div>
                </div>
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
                            <button class="comment-like"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 99</button>
                            <button class="comment-dislike"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 149</button> 
                            <button class="comment-reply reply-popup"><i class="fa fa-reply-all" aria-hidden="true"></i> Reply</button>         
                        </div>
                        <div class="comment-box add-comment reply-box">
                            
                            <span class="mx-10 my-10">
                            <form action="/comments" method="POST">
                                @csrf
                                <input name="plantSubmissionId" type="hidden" value="{{ $submission->plantSubmissionId }}" />
                                <input name="userId" type="hidden" value="{{Auth::id()}}" />
                                <input name="parentId" type="hidden" value="{{$child->commentId}}" />
                                <input name="body" type="text" />
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
