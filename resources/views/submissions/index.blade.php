@extends('layouts.layout')
@section('content')

<div class="container">
    <div class="text-center">
        <h1>Latest submissions</h1>
        <h4><a href="/submissions/create">(Add Submission)</a></h4>
    </div>
    <table class="table">
            <thead>
                <tr>
                <th scope="col">Upvotes</th>
                <th scope="col">Title</th>
                <th scope="col">Plant Scientific Name</th>
                <th scope="col">Author</th>
                <th scope="col">Upload Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $submission)
                <tr>
                    <td>
                        {{$submission->upvotes}}
                    </td>
                    <th>
                        <a href="/submissions/{{$submission->plantSubmissionId}}"> {{$submission->title}} </a>
                    </th>
                    <td>
                        {{DB::table('Plant')->where('plantId', $submission['plantId'])->first()->species}} 
                    </td>
                    <td>
                        {{DB::table('users')->where('userId', $submission['userId'])->first()->email}}
                    </td>
                    <td>
                        {{$submission->created_at->format('m/d/Y')}}
                    </td>
                </tr>
                    @endforeach
            </tbody>
        </table>
    <div class="row">
        {{$submissions->links()}}
    </div>
</div>
 
    
</div>
</body>
@endsection
