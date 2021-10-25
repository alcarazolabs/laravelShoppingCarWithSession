@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cart ({{Cart::content()->count() }})</div>

                <div class="card-body">
                   <form id="products-form"  onsubmit="event.preventDefault(); addProduct();"> 
                            <div class="form-row form-inline">
                                <div class="form-group col-md-6">
                                <label for="inputEmail4">Productos: </label>
                                &nbsp;
                                <select class="form-control" id="product" name="product">
                                    <option value="Aceite">Aceite</option>
                                    <option value="Arroz">Arroz</option>
                                    <option value="Pescado">Pesacado</option>
                                    <option value="Aceitunas">Aceitunas</option>
                                    <option value="Limones">Limones</option>
                                </select>
                                &nbsp;
                                <input class="btn btn-success" type="submit" value="Agregar al carrito">
                                </div>
                            </div>
                    </form>

                    <hr>
                    {{-- {{dd(Cart::content())}} --}}
                   <form id="form-products">
                    <table id="productsTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Unidad Medida</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Cantida</th>
                                <th scope="col">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Cart::content() as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->options->unit }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->price * $item->qty }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>Total: {{Cart::total()}}</td>
                            </tr>
                        </tbody>
                    </table>
                   </form>
                    <hr>
                    <button class="btn btn-success" id="btnComprar">Registrar Compra</button>

                    @if (!count(Cart::content()))
                    <div class="alert alert-info text-center m-0 alerta" role="alert">
                        Your Cart is <b>empty</b>.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
 
<script type="text/javascript">
  
 
  function addProduct(){
      const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;

     // Obtener producto
     var select = document.getElementById('product');
     var value = select.options[select.selectedIndex].value;
     
     fetch(" {{ route('cart.addProduct') }}",{
                method : 'POST',
                body: JSON.stringify({product : ""+value}),
                headers:{
                    'Content-Type': 'application/json',
                    "X-CSRF-Token": csrfToken
                }
            }).then(response =>{
                return response.json()
            }).then( data =>{
               if(data.success){
                    location.reload();

               }else{
                  console.log(data.success);
               }
            }).catch(error =>console.error(error));


  }


  

</script>

@endsection