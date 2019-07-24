<?php

use Illuminate\Database\Seeder;
use \App\Models\Action;
use \Illuminate\Support\Facades\DB;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles_actions')->delete();
        DB::select('ALTER TABLE profiles_actions AUTO_INCREMENT = 1');

        DB::table('actions')->delete();
        DB::select('ALTER TABLE actions AUTO_INCREMENT = 1');

        Action::create(['name' => 'stores.list', 'description' => 'Listar os Grupos', 'method' => 'stores.list']);
        Action::create(['name' => 'stores.update', 'description' => 'Atualizar dados do Grupo', 'method' => 'stores.update']);
        Action::create(['name' => 'stores.store', 'description' => 'Criar novo Grupo', 'method' => 'stores.store']);
        Action::create(['name' => 'orders.list', 'description' => 'Listar os Pedidos', 'method' => 'orders.list']);
        Action::create(['name' => 'orders.update', 'description' => 'Atualizar dados do Pedido','method' => 'orders.update']);
        Action::create(['name' => 'orders.store', 'description' => 'Criar novo Pedido', 'method' =>'orders.store']);

        Action::create(['name' => 'orders.destroy', 'description' => 'Remover (inativar) Pedido','method' => 'orders.destroy']);
        Action::create(['name' => 'stores.destroy', 'description' => 'Remover (inativar) Grupo', 'method' => 'stores.destroy']);
    }
}
