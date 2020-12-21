

@extends('layouts.helloapp')
<style>
    .pagenation{
        font-size: 10px;
    }
    .pagenation li{
        display: inline-block;
    }
    tr th a:link{
        color: white;
    }
    tr th a:visited{
        color: white;
    }
    tr th a:hover{
        color: white;
    }
    tr th a:active{
        color: white;
    }
</style>

@section('title', 'Index')

@section('menubar')
  @parent
  インデックスページ
@endsection

@section('content')

    @if (Auth::check())
        <p>USER: {{$user->name . '(' . $user->email . ')' }}</p>
    @else
    <p>ログインしていません (<a href="http://localhost/20201225_WebDev_TeamMMC/public/login">ログイン</a>|<a href="http://localhost/20201225_WebDev_TeamMMC/public/register">登録</a>)</p>
    @endif

    <table>
        <tr>
            <th><a href="http://localhost/20201225_WebDev_TeamMMC/public/hello?sort=name">Name</a></th>
            <th><a href="http://localhost/20201225_WebDev_TeamMMC/public/hello?sort=mail">Mail</a></th>
            <th><a href="http://localhost/20201225_WebDev_TeamMMC/public/hello?sort=age">Age</a></th>
        </tr>
        @foreach ($items as $item)
        <tr>
            <td>{{$item->name}}</td>
            <td>{{$item->mail}}</td>
            <td>{{$item->age}}</td>
        </tr>
        @endforeach
    </table>
    {{$items->appends(['sort' => $sort])->links('pagination::bootstrap-4')}}
@endsection

@section('footer')
copyright 2020
@endsection
