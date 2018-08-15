<?php

use Illuminate\Database\Seeder;
use App\Models\OrderType;

class OrderTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_type')->delete();

        OrderType::create(['name' => 'Por Catálogo',
                           'description' => 'Esse tipo de pedido, você enviará para o sistema um catálogo e o cliente que dirá o numero do modelo, cor, tamanho e quantidade de itens.']);
        OrderType::create(['name' =>
                           'Por Item', 'description' => 'Esse tipo de pedido, você deverá enviar todos os itens que deseja vender, informando pelo menos, nome, foto, modelo, cores disponíveis e uma foto do produto. Porém o catalogo pode ser enviado também.']);
    }
}
