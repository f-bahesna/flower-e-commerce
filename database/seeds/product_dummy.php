<?php

use Illuminate\Database\Seeder;

class product_dummy extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(0,11) as $i){
            // $factory->define(App\Models\packageTourModel::class, function (Faker $faker) {
                $arrayName = [  'Bunga Amarilis',
                                'Bunga Begonia',
                                'Bunga Geranium',
                                'Bunga Lisianthus',
                                'Cemara Angin',
                                'Cemara Inoki',
                                'Cemara Perak',
                                'Kaktus Ariocarpus',
                                'Kaktus Careus Tetragonus',
                                'Kaktus Echinocactus Grusonii',
                                'Kaktus Parodia',
                                'Tanaman Air Lotus'
                            ];

                $arrayImage = [ 'Bunga-Amarilis.jpeg',
                                'Bunga-Begonia.jpeg',
                                'Bunga-Geranium.jpeg',
                                'Bunga-Lisianthus.jpeg',
                                'Cemara-Angin.jpeg',
                                'Cemara-Inoki.jpeg',
                                'Cemara-Perak.jpeg',
                                'Kaktus-Ariocarpus.jpeg',
                                'Kaktus-Careus-Tetragonus.jpeg',
                                'Kaktus-Echinocactus-Grusonii.jpeg',
                                'Kaktus-Parodia.jpeg',
                                'Tanaman-Air-Lotus.jpeg'
                            ];
                $arrayJenis = ['bunga','bunga','bunga','bunga','cemara','cemara','cemara','kaktus','kaktus','kaktus','kaktus','tanaman'];
                $arrayUmur = [1,2,3,5,8,7,6,5,6,7,6,10];
                $arrayHarga = [100000,250000,3000000,580000,80000,75000,65000,50000,67000,780000,60000,150000];
                $arrayStatus = ['published','published','published','published','published','published','published','published','published','published','drafted','drafted'];

                DB::table('products')->insert(
                    [
                        'nama_product' => $arrayName[$i],
                        'gambar_product' => $arrayImage[$i],
                        'jenis_product' =>  $arrayJenis[$i],
                        'harga_product' =>  $arrayHarga[$i],
                        'umur_product' =>  $arrayUmur[$i],
                        'status_product' => $arrayStatus[$i],
                        'keterangan_product' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, 
                                                    and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
                        'created_by' => "Seeder System",
                        'created_at' => date('Y-m-d H:i:s'),
                   ]
                  );
        }
    }
}
