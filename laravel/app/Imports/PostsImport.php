<?php

namespace App\Imports;

use App\Http\Controllers\Museum\Admin\PostController;
use App\Models\MuseumPost;
use App\Repositories\MuseumCategoryRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PostsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    private $museumCategoryRepository;

    function __construct() {
        $this->museumCategoryRepository = app(MuseumCategoryRepository::class);
    }


    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $value) {
            if ($key > 0) {
                $coordinates = [
                    'lat' => $this->getCoordinate($value[7]),
                    'lng' => $this->getCoordinate($value[8])
                ];

                $collectionDate = Date::excelToDateTimeObject($value[6]);


                DB::table('museum_posts')->insert([
                    'user_id' => Auth::id(),
                    'inventory_number' => $value[0],
                    'barcode' => $value[0],
                    'adopted_name' => $value[1],
                    'label_name' => $value[2],
                    'russian_name' => $value[3],
                    'category_id' => $this->getCategoryId($value[4]),
                    'label_text' => $value[5],
                    'collection_date' => $collectionDate ? $collectionDate : '',
                    'coordinates' => json_encode($coordinates),
                    'accuracy' => $value[9],
                    'collectors' => $value[10],
                    'determination' => $value[11],
                    'environmental_status' => $value[12],
                    'created_at' => \Illuminate\Support\Facades\Date::now(),
                    'updated_at' => \Illuminate\Support\Facades\Date::now()
                ]);
            }

        }
    }

    private function getCoordinate($coordinate)
    {
        if (str_contains($coordinate, '°')) {
            $dotPos = stripos($coordinate, '°');
            $str = preg_replace('/[^A-Za-z0-9\-]/', '', $coordinate);
            $str = substr_replace($str, '.', $dotPos - 1, 0);

            return $str;
        } else {
            return $coordinate;
        }
    }

    private function getCategoryId($name)
    {
        if (!empty($name)) {
            $category = $this->museumCategoryRepository->getCategoryByName($name);
            if ($category) {
                $category = $category[0]['id'];
            } else {
                $category = null;
            }
            return $category ? $category : 1;
        } else {
            return 1;
        }
    }

}
