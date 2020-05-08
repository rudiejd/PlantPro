@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="text-center">
            <h1>Administration</h1>
            <h4>Promote Admins</h4>
            <form action="/makeAdmin" method="POST">
                @csrf
                <input type="hidden" name="adminId" value="{{Auth::id()}}" />
                <div class="form-group">
                    <label for="userId">User</label>
                    <select id="userId" name="userId" class="form-control" required>
                        @foreach ($users as  $user)
                            @if (!$user->isAdmin())
                                <option value="{{$user->userId}}" class="text-center">{{$user->email}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" />
            </form>
            <h4>Promote Moderators</h4>
            <form action="/makeMod" method="post">
                @csrf
                <div class="form-group">
                    <label for="userId">User</label>
                    <select id="userId" name="userId" class="form-control" required>
                        @foreach ($users as  $user)
                            @if (!$user->isMod() && !$user->isAdmin())
                                <option value="{{$user->userId}}" class="text-center">{{$user->email}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <input type="submit" class="btn btn-primary"/>
            </form>
            <h4>Demote Moderators</h4>
            <form action="/removeMod" method="post">
                @csrf
                <div class="form-group">
                    <label for="userId">User</label>
                    <select id="userId" name="userId" class="form-control" required>
                        @foreach ($users as  $user)
                            @if ($user->isMod())
                                <option value="{{$user->userId}}" class="text-center">{{$user->email}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <input type="submit" class="btn btn-primary"/>
            <form>
    </div>
</div>
@endsection