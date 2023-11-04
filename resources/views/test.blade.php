<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

    @foreach($data["results"] as $proxy)
    <p>ID: {{ $proxy["id"] }}</p>
    <h1>Proxy Address: {{ $proxy["proxy_address"] }}</h1>

     @endforeach

    
 
</body>
</html>