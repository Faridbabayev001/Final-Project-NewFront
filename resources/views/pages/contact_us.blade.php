@extends('pages.layout')

@section('title','Əlaqə')

@section('content')
  <div id="breadcrumb">
  <div class="container">
     <div class="row">
        <div class="col-lg-12">
          <h1 class="text-left">Bizimlə Əlaqə</h1>
        </div>
    </div>
  </div>
</div>
<section id="contact-us">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="col-lg-12 padding0">
            <ul class="about-us-social-block list-inline col-lg-12 padding0">
              <li class="col-lg-3"><img src="/images/contact-us-fb.png" class="img-responsive" alt="Facebook icon"></li>
              <li class="col-lg-9"><a href="#"><h1>/Bumeranq.org</h1></a></li>
            </ul>

            <ul class="about-us-social-block list-inline col-lg-12 padding0">
              <li class="col-lg-3"><img src="/images/contact-us-tw.png" class="img-responsive" alt="Twitter icon"></li>
              <li class="col-lg-9"><a href="#"><h1>@Bumeranq.org</h1></a></li>
            </ul>

            <ul class="about-us-social-block list-inline col-lg-12 padding0">
              <li class="col-lg-3"><img src="/images/contact-us-gp.png" class="img-responsive" alt="Twitter icon"></li>
              <li class="col-lg-9"><a href="#"><h1>+Bumeranq.org</h1></a></li>
            </ul>
        </div>
      </div>
      <div class="col-lg-8 contact-us-form">
        <form action="{{url('/Əlaqə')}}" method="post">
          {{csrf_field()}}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name">Ad, Soyad:</label>
            <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}">
            @if ($errors->has('name'))
              <span class="help-block">
                  <strong>Boşluq buraxmayın</strong>
              </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" id="email" value="{{old('email')}}">
            @if ($errors->has('email'))
              <span class="help-block">
                  <strong>Boşluq buraxmayın</strong>
              </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
            <label for="message">Mesaj:</label>
            <textarea id="message" class="form-control" name="message" rows="8" cols="80">{{old('message')}}</textarea>
            @if ($errors->has('message'))
              <span class="help-block">
                  <strong>Boşluq buraxmayın</strong>
              </span>
            @endif
          </div>
          <input type="submit" class="btn pull-right" value="Göndər">
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
