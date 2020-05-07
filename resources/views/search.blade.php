@extends('layouts.layout')
@section('content')
@php 

    $plants = DB::table('Plant')->get();
    $users = DB::table('users')->get();
@endphp


<div class="container">
    </br>
    <div class="text-center">
        <h1>Search</h1>
        <h4>Advanced Options:</h4>
        <form class="active-cyan-2  " action="/search" method="get">
            <div class="form-group">
                <label for="plantId">Plant</label>
                <select id="plantId" name="plantId" class="form-control" required>
                    @foreach ($plants as $plant)
                        <option value="{{$plant->plantId}}" class="text-center">{{$plant->commonName}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="userId">User</label>
                <select id="userId" name="userId" class="form-control" required>
                    @foreach ($users as  $user)
                        <option value="{{$user->userId}}" class="text-center">{{$user->email}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Search" name="query"
                aria-label="Search">
            </div>
        <i class="fas fa-search" aria-hidden="true"></i>
        </form>
            
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
