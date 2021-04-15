<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 15.11.2020
 * Time: 19:51
 */

namespace App\Repositories;

use App\Models\MuseumImage as Model;
use App\Models\MuseumImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class MuseumImageRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    public function getAllImagesByPostId($postId)
    {
        $columns = [
            'id',
            'post_id',
            'alias'
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->where('post_id', $postId)
            ->toBase()
            ->get();

        return $result;

    }

    public function getImageByPostIdAndId($postId, $imageId)
    {

        $columns = [
            'id',
            'post_id',
            'alias'
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->where([
                ['post_id', '=', $postId],
                ['id', '=', $imageId]
            ])
            ->toBase()
            ->get();

        return $result;

    }

    public function createImage($request, $image, $postId)
    {
        $path = $this->setFileInStorage($request, $image, $postId);

        if ($path != false) {
            $path = '/storage/' . $path;

            if ($path) {

                $data = array(
                    'post_id' => $postId,
                    'name' => $this->getFileName($request, $image),
                    'alias' => $path,
                );

                $imgobject = new MuseumImage();
                $imgobject->create($data);

                return $path;
            }
        } else {
            return false;
        }
    }

    public function updateImage($request, $image, $postId, $item)
    {

        $path = $this->setFileInStorage($request, $image, $postId);

        if ($path) {
            $data = array(
                'name' => $this->getFileName($request, $image),
                'alias' => '/storage/' . $path
            );

            $result = $this->startConditions()::where('id', '=', $item->id)->update($data);

            if ($result > 0) {
                return '/storage/' . $path;
            } else {
                return false;
            }
        }

    }

    public function deleteImageFromFilesystem($alias)
    {
        $pathInFileSystem = substr($alias, 8, strlen($alias));

        $isDeleted = Storage::disk('public')->delete($pathInFileSystem);

        return $isDeleted;
    }

    public function deleteMoreImagesFromFileSystem($postIds)
    {
        try {
            foreach ($postIds as $postId) {
                $this->deleteAllImagesByPost($postId);
            }
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    public function deleteAllImagesByPost($postId)
    {
        $result = false;
        $isExistsDir = Storage::disk('public')->exists('images/posts/' . $postId);
        if ($isExistsDir) {
            $result = Storage::disk('public')->deleteDirectory('images/posts/' . $postId);
        }

        return $result;
    }

    private function setFileInStorage($request, $image, $postId)
    {
        $path = Storage::disk('public')->putFileAs(
            'images/posts/' . $postId,
            $image,
            $this->getFileName($request, $image)
        );

        return $path;
    }

    private function getFileName($request, $image)
    {
        $date = str_replace(' ', '_', $request->updated_at);
        $date = str_replace(':', '_', $date);

        $fileName = $date . '_' . rand(100, 1000000) . '_' . Str::random(10) . '_' . $image->getClientOriginalName();

        return $fileName;

    }


}