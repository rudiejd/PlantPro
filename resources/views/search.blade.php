@extends('layouts.layout')
@section('content')

<div class="container">
    </br>
    <div class="text-center">
        <h1>Search Results</h1>
    </div>
    @if (sizeof($submissions) > 0)
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
                        {{DB::table('Plant')->where('plantId', $submission['plantId'])->first()->genus}} {{DB::table('Plant')->where('plantId', $submission['plantId'])->first()->species}} 
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
                {{$submissions->links() }}
            </div>
    @else
        <div class="content-center text-center text-muted">
            No results found for your search. Please enter a new search or try again.
        </div>
    @endif
</div>
 
    
</div>
</body>
@endsection
