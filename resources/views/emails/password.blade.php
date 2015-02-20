<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>{{$message->getSubject()}}</title>
    </head>
    <body>
        <p>Haz click en el link para cambiar tu contraseña</p>
        <p>{!!link_to('password/reset/'.$token, 'Reset Password')!!}</p>
    </body>
</html>