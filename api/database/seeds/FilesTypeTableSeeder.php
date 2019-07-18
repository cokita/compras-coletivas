<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\FilesType;

class FilesTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('files_type')->delete();

        FilesType::create(['name' => 'Imagem']);
        FilesType::create(['name' => 'PDF']);
    }
}
