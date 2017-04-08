@extends('admin.layout')

@section('title','Admin panel')

@section('content')
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="widget widget-tile">
                    <div id="spark1" class="chart sparkline"></div>
                    <div class="data-info">
                        <div class="desc">İstifadəçi sayı</div>
                        <div class="value"><span class="indicator indicator-equal mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="{{$user_count}}" class="number">0</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="widget widget-tile">
                    <div id="spark2" class="chart sparkline"></div>
                    <div class="data-info">
                        <div class="desc">İstək sayı</div>
                        <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="{{$istek_count }}" data-suffix="" class="number">0</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="widget widget-tile">
                    <div id="spark3" class="chart sparkline"></div>
                    <div class="data-info">
                        <div class="desc">Dəstək sayı</div>
                        <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="{{$destek_count}}" class="number">0</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="widget widget-tile">
                    <div id="spark4" class="chart sparkline"></div>
                    <div class="data-info">
                        <div class="desc">Admin sayı</div>
                        <div class="value"><span class="indicator indicator-negative mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="1" class="number">0</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default panel-table">
                        <div class="panel-heading">
                            <div class="title">İstifadəçi siyahısı</div>
                        </div>
                        <div class="panel-body table-responsive">
                            <table class="table table-striped table-borderless">
                                <thead>
                                <tr>
                                    <th style="width:40%;">Avatar</th>
                                    <th style="width:40%;">Username</th>
                                    <th style="width:20%;">Əlaqə nömrəsi</th>
                                    <th style="width:20%;">Email</th>
                                </tr>
                                </thead>
                                <tbody class="no-border-x">
                                @foreach (array_chunk($users->getCollection()->all(), 4) as $row)

                                    @foreach($row as $user)
                                        <tr>
                                            <td class="user-avatar"> <img src="/image/{{$user->avatar}}" alt="Avatar">Penelope Thornton</td>
                                            <td>{{$user->username}}</td>
                                            <td>{{$user->phone}}</td>
                                            <td>{{$user->email}}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                            {{$users->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection