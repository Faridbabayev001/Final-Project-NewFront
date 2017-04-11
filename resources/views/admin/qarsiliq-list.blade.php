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
                                  <td><a href="/single/{{ $qarsiliq->elan->id }}" target="_blank">{{ $qarsiliq->elan->title }}</a></td>
                                  <td>{{ $qarsiliq->elan->name}}</td>
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
