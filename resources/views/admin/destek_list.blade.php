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
                                  <th>Status</th>
                                  <th>Dəyiş</th>
                                  <th>Bax</th>
                                  <th>Başlıq</th>
                                  <th>Adres</th>
                                  <th>Ad</th>
                                  <th>Email</th>
                                  <th>Şəkil</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach (array_chunk($destekler->getCollection()->all(), 4) as $row)


                            @foreach($row as $destek)
                              @if($destek->type_id=='1')

                                <tr>
                                    @if($destek->status=='0')
                                      <td><a onclick="btnActive({{$destek->id}})" class="btn btn-success" href="{{url('/activate/'.$destek->id)}}">Aktivləşdir</a></td>

                                    @else
                                      <td><a class="btn btn-warning" href="{{url('/deactivate/'.$destek->id)}}">Deaktivləşdir</a></td>
                                    @endif
                                    <td><a href="/admin/elan-edit/{{$destek->id}}" class="btn btn-primary">Dəyiş</a></td>
                                    <td><a data-toggle="modal" data-target="#{{$destek->id}}" class="btn btn-success">Bax</a></td>
                                    <td>{{$destek->title}}</td>
                                    <td>{{substr($destek->location, 0,50)}}</td>
                                    <td>{{$destek->name}}</td>
                                    <td>{{$destek->email}}</td>
                                    <td><a href="#"><img style="width:50px; height:50px" src="{{url('image/'.$destek->shekiller[0]->imageName)}}"/></a></td>
                                    <div id="{{$destek->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="m odal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                      <h4 class="modal-title" id="myModalLabel">{{$destek->title}}</h4>
                                    </div>
                                    <div class="modal-body">
                                      <ul class="list-group">
                                        <li class="list-group-item"><b>Məlumat:</b> {{$destek->about}}</li>
                                        <li class="list-group-item"><b>Ad & Soyad:</b> {{$destek->name}}</li>
                                        <li class="list-group-item"><b>İstifadəçi Ad & Soyadı:</b> {{$destek->user->name}}</li>
                                        <li class="list-group-item"><b>Əlaqə nömrəsi:</b> {{$destek->phone}}</li>
                                        <li class="list-group-item"><b>Email:</b> {{$destek->email}}</li>
                                        <li class="list-group-item"><b>Təşkilat:</b> {{$destek->org}}</li>
                                        <li class="list-group-item"><b>Növ:</b> {{$destek->nov}}</li>
                                        <li class="list-group-item"><b>Deadline vaxtı:</b> {{$destek->deadline}}</li>
                                      </ul>
                                      <hr>
                                      <h3>Digər Şəkillər:</h3>
                                      <div class="row">
                                        @php
                                          $isFirst = true;
                                        @endphp
                                        @foreach($destek->shekiller as $imgName)
                                          @if ($isFirst)
                                            @php
                                              $isFirst = false;
                                              continue;
                                            @endphp
                                          @endif
                                          <div class="col-lg-3">
                                              <img src="{{url('/image/'.$imgName->imageName)}}" style="height:150px; cursor:pointer" class="admin-panel-other-photo img-responsive" alt="" />
                                          </div>
                                          @endforeach
                                      </div>
                                      <hr>
                                      <h3>Əsas şəkil:</h3>
                                      <div class="col-lg-12">
                                        <img class="admin-panel-main-photo img-responsive" src="{{url('image/'.$destek->shekiller[0]->imageName)}}" alt="" />
                                      </div>
                                      <hr>
                                    </div>


                                    <div class="modal-footer">
                                    </div>
                                  </div>
                                </div>
                              </div>
                                </tr>
                            @endif
                            @endforeach
                            @endforeach
                          </tbody>
                      </table>

                      <div class="col-lg-12 center-block" style="float:none !important">
                        {{$destekler->links()}}
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection
@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.js"></script>
  <script src="{{url('/js/moment.js')}}"></script>
  <script src="{{url('/js/socket-data.js')}}"></script>
<script>
socketData(0,0,0);
</script>

<script>
  $(document).ready(function() {
    var mainPhoto = $('.admin-panel-main-photo');
    var otherPhoto = $('.admin-panel-other-photo');

    otherPhoto.click(function() {
      mainPhoto.attr('src', $(this).attr('src'));
    });
  });
</script>
@endsection
