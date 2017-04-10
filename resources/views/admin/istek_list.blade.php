@extends('admin.layout')

@section('title','İstək list')

@section('content')
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  İstək siyahısı
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
                            @foreach (array_chunk($istekler->getCollection()->all(), 4) as $row)


                            @foreach($row as $istek)
                              @if($istek->type_id=='2')

                                <tr style="cursor: pointer">
                                    @if($istek->status=='0')
                                      <td><a onclick="btnActive({{$istek->id}})" class="btn btn-success" href="{{url('/activate/'.$istek->id)}}">Aktivləşdir</a></td>

                                    @else
                                      <td><a class="btn btn-warning" href="{{url('/deactivate/'.$istek->id)}}">Deaktivləşdir</a></td>
                                    @endif
                                    <td><a href="/admin/elan-edit/{{$istek->id}}" class="btn btn-primary">Dəyiş</a></td>
                                    <td><a data-toggle="modal" data-target="#{{$istek->id}}" class="btn btn-success">Bax</a></td>
                                    <td>{{$istek->title}}</td>
                                    <td>{{substr($istek->location, 0,50)}}</td>
                                    <td>{{$istek->name}}</td>
                                    <td>{{$istek->email}}</td>
                                    <td><a href="#"><img style="width:50px; height:50px" src="{{url('image/'.$istek->shekiller[0]->imageName)}}"/></a></td>
                                    <div id="{{$istek->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="m odal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                      <h4 class="modal-title" id="myModalLabel">{{$istek->title}}</h4>
                                    </div>
                                    <div class="modal-body">
                                      <ul class="list-group">
                                        <li class="list-group-item"><b>Məlumat:</b> {{$istek->about}}</li>
                                        <li class="list-group-item"><b>Ad & Soyad:</b> {{$istek->name}}</li>
                                        <li class="list-group-item"><b>Əlaqə nömrəsi:</b> {{$istek->phone}}</li>
                                        <li class="list-group-item"><b>Email:</b> {{$istek->email}}</li>
                                        <li class="list-group-item"><b>Təşkilat:</b> {{$istek->org}}</li>
                                        <li class="list-group-item"><b>Növ:</b> {{$istek->nov}}</li>
                                        <li class="list-group-item"><b>Deadline vaxtı:</b> {{$istek->deadline}}</li>
                                      </ul>
                                      <hr>
                                      <h3>Digər Şəkillər:</h3>
                                      <div class="row">
                                        @php
                                          $isFirst = true;
                                        @endphp
                                        @foreach($istek->shekiller as $imgName)
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
                                        <img class="admin-panel-main-photo img-responsive" src="{{url('image/'.$istek->shekiller[0]->imageName)}}" alt="" />
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
                        {{$istekler->links()}}
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
socketData(0,0);
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
