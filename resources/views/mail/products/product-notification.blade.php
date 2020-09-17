
<p style="color:#333">
    Oĺá <strong> {{$customer}}</strong>,
    Recebemos o seu pedido.<br>

    Lista de Pedidos
    <div class="row">
        <table class="table">
            <thead>
              <tr>
                <th><strong>Pastel</strong></th>
                <th><strong>Preço</strong></th>
              </tr>
            </thead>
            <tbody>
            @foreach ($products  as $item)
            <tr>
              <td>   {{ $item->name }}</td>
              <td>R$ {{ $item->price }}</td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
    </div>

</p>
