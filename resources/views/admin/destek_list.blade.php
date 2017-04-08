@extends('admin.layout')

@section('title','İstək list')

@section('content')
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  Istək siyahısı
              </div>
              <div class="panel-body">
                  <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th>Status</th>
                                  <th>Dəyiş</th>
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

                                <tr data-toggle="modal" data-target="#{{$destek->id}}" style="cursor: pointer">
                                    @if($destek->status=='0')
                                      <td><a onclick="btnActive({{$destek->id}})" class="btn btn-success" href="{{url('/activate/'.$destek->id)}}">Aktivləşdir</a></td>

                                    @else
                                      <td><a class="btn btn-warning" href="{{url('/deactivate/'.$destek->id)}}">Deaktivləşdir</a></td>
                                    @endif
                                    <td><a href="/admin/elan-edit/{{$destek->id}}" class="btn btn-primary">Dəyiş</a></td>
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
                                      {{$destek->about}}
                                    </div>
                                     {{-- SLIDER PART --}}
                                     {{-- mecbur qalib style burda yazdm --}}
                                      <style type="text/css">
                                        .littleImg{
                                           width: 18%;
                                           height: 100px;
                                            overflow: hidden;
                                            float: left;
                                           margin: 3% 0 0 2%;
                                        }
                                      </style>
                                    @foreach($destek->shekiller as $imgName)
                                    <div class="littleImg">
                                        <img src="{{url('/image/'.$imgName->imageName)}}" class="img-responsive" alt="" />
                                    </div>
                                      @endforeach

                                    <div class="mainImg modal-footer">
                                       <img class="img-responsive " src="{{url('image/'.$destek->shekiller[0]->imageName)}}"/>
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

                      {{$destekler->links()}}
                  </div>
              </div>
          </div>
      </div>
  </div>
  <script src="{{url('/js/vendor/jquery-2.2.4.min.js')}}"></script>
@endsection
@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.js"></script>
  <script src="{{url('/js/moment.js')}}"></script>
  <script src="{{url('/js/socket-data.js')}}"></script>
<script>
socketData(0,0);

function btnActive(id) {
 console.log(id)
}
</script>
