@extends('admin.layout')

@section('title','Qarşılıq siyahısı')

@section('content')
  <div class="row main-content">
    <div class="col-xs-12 col-md-6 col-lg-5">
        <div class="widget widget-tile">
          <div class="data-info">
              <div class="desc" style="color:green"><b>Qəbul olunan qarşılıq sayı:</b></div>
              <div class="value"><span class="indicator indicator-equal mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="{{ $zeroCount }}" class="number">0</span>
              </div>
          </div>
            <div class="data-info">
                <div class="desc" style="color:red"><b>Qəbul olunmayan qarşılıq sayı:</b></div>
                <div class="value"><span class="indicator indicator-equal mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="{{ $oneCount }}" class="number">0</span>
                </div>
            </div>
        </div>
    </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  Qarşılıq siyahısı
              </div>
              <div class="panel-body">
                  <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th>Status</th>
                                  <th>Elan növü</th>
                                  <th>Ad</th>
                                  <th>Elan</th>
                                  <th>Elan sahibi</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach ($qarsiliqs as $qarsiliq)
                                <tr>
                                  @if ($qarsiliq->data == 1)
                                    <td><b style="color:green">Qəbul olunub</b></td>
                                    @else
                                    <td><b style="color:red">Qəbul olunmayıb</b></td>
                                  @endif
                                  @if ($qarsiliq->elan->type_id == 2)
                                    <td style="color:green">İstək</td>
                                    @else
                                    <td style="color:red">Dəstək  </td>
                                  @endif
                                  <td>{{ $qarsiliq->user->name }}</td>
                                  <td><a data-toggle="modal" data-target="#{{$qarsiliq->elan->id}}" href="#" target="_blank">{{ $qarsiliq->elan->title }}</a></td>
                                  <td>{{ $qarsiliq->elan->name}}</td>
                                  <div id="{{$qarsiliq->elan->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="m odal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">{{$qarsiliq->elan->title}}</h4>
                                  </div>
                                  <div class="modal-body">
                                    <ul class="list-group">
                                      <li class="list-group-item"><b>Məlumat:</b> {{$qarsiliq->elan->about}}</li>
                                      <li class="list-group-item"><b>Ad & Soyad:</b> {{$qarsiliq->elan->name}}</li>
                                      <li class="list-group-item"><b>İstifadəçi Ad & Soyadı:</b> {{$qarsiliq->elan->user->name}}</li>
                                      <li class="list-group-item"><b>Əlaqə nömrəsi:</b> {{$qarsiliq->elan->phone}}</li>
                                      <li class="list-group-item"><b>Email:</b> {{$qarsiliq->elan->email}}</li>
                                      <li class="list-group-item"><b>Təşkilat:</b> {{$qarsiliq->elan->org}}</li>
                                      <li class="list-group-item"><b>Növ:</b> {{$qarsiliq->elan->nov}}</li>
                                      <li class="list-group-item"><b>Deadline vaxtı:</b> {{$qarsiliq->elan->deadline}}</li>
                                    </ul>
                                    <hr>
                                    <h3>Digər Şəkillər:</h3>
                                    <div class="row">
                                      @php
                                        $isFirst = true;
                                      @endphp
                                      @foreach($qarsiliq->elan->shekiller as $imgName)
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
                                      <img class="admin-panel-main-photo img-responsive" src="{{url('image/'.$qarsiliq->elan->shekiller[0]->imageName)}}" alt="" />
                                    </div>
                                    <hr>
                                  </div>


                                  <div class="modal-footer">
                                  </div>
                                </div>
                              </div>
                            </div>
                                </tr>
                            @endforeach
                          </tbody>
                      </table>

                      <div class="col-lg-12 center-block" style="float:none !important">
                        {{$qarsiliqs->links()}}
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
