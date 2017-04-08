<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin panel</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <section id="admin-panel-login">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="login-logo">
            <img class="center-block" src="/images/logo.png" alt="Logo">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 login-block center-block">
          <form role="form" method="POST" action="/alfagen/postLogin">
            {{ csrf_field() }}
            <input type="text" name="email" class="form-control" placeholder="Email">
            <input type="password" name="password" class="form-control" placeholder="Şifrə">
            <input type="submit" name="submit" value="Daxil ol" class="form-control btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
