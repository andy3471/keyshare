@extends('layouts.app')

@section('header')
    {{ __('admin.users') }}
@endsection

@section('content')
<div class="container">
    <table class="table">
        @if(count($users) > 0)
            <tr>
                <th>{{ __('users.name') }}</th>
                <th>{{ __('users.email') }}</th>
                <th>{{ __('admin.approved') }}</th>
            </tr>
            @foreach($users as $user)
                <tr>
                <td>
                    <img src="{{ $user->image }}" height="25px" width="25px">
                    <a href="/admin/user/{{$user->id}}">{{ $user->name }}</a>
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    @if($user->approved)
                        {{ __('admin.approved') }}
                    @else
                        {{ __('admin.notapproved') }}
                    @endif
                </td>
                <tr>
            @endforeach


        @else
            <p> {{ __('admin.nousers') }} <p>
        @endif
    </table>
     {{ $users->links() }}
</div>
@endsection
