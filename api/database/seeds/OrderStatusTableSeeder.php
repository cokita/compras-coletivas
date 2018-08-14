<?php

use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_type')->delete();

        OrderStatus::create(['name' => 'Em preparação', 'description' => 'O pedido ainda não está aberto para compras, o vendedor está preparando o pedido.']);
        OrderStatus::create(['name' => 'Aberto', 'description' => 'Pedido liberado para venda.']);
        OrderStatus::create(['name' => 'Aguardando pagamento', 'description' => 'Pedido encontra-se em fase de pagamento.']);
        OrderStatus::create(['name' => 'Fechamento', 'description' => 'A vendedora está consolidando as informações do pedido para enviar para a fábrica.']);
        OrderStatus::create(['name' => 'Enviado', 'description' => 'A vendedora enviou o pedido para o fabricante.']);
        OrderStatus::create(['name' => 'Postado', 'description' => 'A fábrica enviou o pedido para a transportadora responsável.']);
        OrderStatus::create(['name' => 'Entregue', 'description' => 'A transportadora entregou o pedido na casa da vendedora e os produtos estão em separação.']);
        OrderStatus::create(['name' => 'Aguardando Retirada', 'description' => 'Produtos liberados para entrega.']);
        OrderStatus::create(['name' => 'Fechado', 'description' => 'Pedido Fechado.']);
    }
}
