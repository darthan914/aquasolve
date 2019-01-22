<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <p>
      Hai, {{ $data[0]['name'] }}.
    </p>

    <p>
      Your email has been add Admin CMS Aquasolve account.
      <br>Please login with
      <br><br>
      Email : {{ $data[0]['email'] }}<br>
      Password : {{ $data[0]['password'] }}
      <br><br>
      <br><br>

      <a href="{{ URL::to('admin/login') }}">
        {{ URL::to('admin/login/') }}
      </a>
    </p>

  </body>
</html>