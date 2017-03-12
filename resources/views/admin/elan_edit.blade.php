@extends('admin.layout')

@section('title','Elan Edit')

@section('content')
  <div class="row">
    @if (Session::has('success'))
      <div class="alert alert-success">
        {{Session::get('success')}}
      </div>
    @endif
    <div class="col-lg-12">
      <h1>{{$elan->type_id  == 1 ? 'Dəstək' : 'İstək'}} edit:</h1>
      <br>
      <hr>
      <form class="form-group" action="/admin/elan-edit/{{$elan->id}}" method="post">
        {{ csrf_field() }}
        <h3>Başlıq:</h3>
        <br>
        <input type="text" name="title" class="form-control" value="{{$elan->title}}">
        <br>
        <h3>Açıqlama:</h3>
        <br>
        <textarea name="about" class="form-control" rows="8" cols="80">{{$elan->about}}</textarea>
        <br>
        <input type="submit" name="submit" value="Göndər" class="btn btn-success">
      </form>
    </div>
  </div>
@endsection
