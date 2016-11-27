@extends('admin.layout')

@section('title','Dəstək list')

@section('content')
  <div class="row">

      <div class="col-md-12 col-sm-12 col-xs-12">

          <div class="panel panel-default">
              <div class="panel-heading">
                  Dəstək siyahısı
              </div>
              <div class="panel-body">
                  <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th>status</th>
                                  <th>title</th>
                                  <th>about</th>
                                  <th>location</th>
                                  <th>name</th>
                                  <th>phone</th>
                                  <th>email</th>
                                  <th>image</th>
                                  <th>org</th>
                                  <th>nov</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach($destekler as $destek)
                              @if($destek->type_id=='1')
                              <tr>
                                 @if($destek->status=='0')
                                  <td><a class="btn btn-success" href="{{url('/activate/'.$destek->id)}}">Aktiləşdir</a></td>
                                @else
                                  <td><a class="btn btn-warning" href="{{url('/deactivate/'.$destek->id)}}">Deaktivləşdir</a></td>
                                @endif
                                  <td>{{$destek->title}}</td>
                                  <td><a href="#" data-toggle="modal" data-target="#{{$destek->id}}">{{substr($destek->about, 0,10)}}</a></td>
                                  <td>{{$destek->location}}</td>
                                  <td>{{$destek->name}}</td>
                                  <td>{{$destek->phone}}</td>
                                  <td>{{$destek->email}}</td>
                                  <td><img style="width:50px; height:50px" src="{{url('image/'.$destek->image)}}"/></td>
                                  <td>{{$destek->org}}</td>
                                  <td>{{$destek->nov}}</td>
                            </tr>
                            <div id="{{$destek->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">{{$destek->title}}</h4>
                                  </div>
                                  <div class="modal-body">
                                    {{$destek->about}}
                                  </div>
                                  <div class="modal-footer">
                                     <img class="img-responsive " src="{{url('image/'.$destek->image)}}"/>
                                  </div>
                                </div>
                              </div>
                            </div>
                            @endif
                            @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection
