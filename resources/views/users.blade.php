<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>
  
  <select name="category" id="category">
    <option value="">Select Categorie</option>
    @if(count($categories)>0)
      @foreach($categories as $category)
        <option value="{{$category['id']}}">{{$category->id}}</option>
      @endforeach
    @endif
  </select>

  <table>
    <tr>
      <th>ID</th>
      <th>IP</th>
      <th>NAME</th>
    </tr>
    <tbody id="tbody">
      @if(count($products)>0)
        @foreach($products as $product)
          <tr>
            <td>{{$product['id']}}</td>
            <td>{{$product['Ip']}}</td>
            <td>{{$product['Name']}}</td>
          </tr>
        @endforeach
      @endif
    </tbody>
  </table>

  <script>
    $(document).ready(function(){
      $("#category").on('change',function(){
          var category = $(this).val();
          //console.log(category);
          
          $.ajax({
            url:"{{route('filter')}}",
            type:"GET",
            data:{'category':category},
            success : handleData
            
          });
          function handleData(data) 
          {
            //alert(data);
            console.log(data);
            var products = data.products;
            var html = '';
            if(products.length>0)
            {
              for(let i =0;i<products.length;i++){
                html+='<tr>\
                  <td>'+i+'</td>\
                  <td>'+products[i]['id']+'</td>\
                  <td>'+products[i]['Ip']+'</td>\
                  <td>'+products[i]['Name']+ '</tr>';
              }

            }
            else{
              html +='<tr>\
                <td>No products found</td>\
                </tr>';
            }

            $("#tbody").html(html);
          }
          
      });
    });
  </script>
</body>
</html>