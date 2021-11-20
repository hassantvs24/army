<?php


namespace App\Custom;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class ImgUpload
{
    public $disk;
    public $extension;


    public function __construct($disk, $extension='png')
    {
        $this->disk = $disk;
        $this->extension = $extension;
    }

    public function upload($image, $weight, $height, $name=null){
        $fileName = md5(mt_rand()).'.'.$this->extension;
        if(isset($name)){
            $fileName = $name;
        }

        $photoSm = Image::make($image);//$request->file('logo')
        $photoSm->resize($weight, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $photoSm->resizeCanvas($weight, $height, 'center', false, 'rgba(255, 255, 255, 0)');
        $photo_main = $photoSm->stream($this->extension);

        if(Storage::disk($this->disk)->put($fileName, $photo_main->__toString())){
            return $fileName;
        }

        throw new \Exception('File not uploaded.');
    }

    public function del($img){

        if (Storage::disk($this->disk)->exists($img)) {
            if(Storage::disk($this->disk)->delete($img)){
                return true;
            }

            throw new \Exception('File not Deleted.');
        }

        throw new \Exception('File not found');
    }

    public function del_ex($img){
        if (Storage::disk($this->disk)->exists($img)) {
            if(Storage::disk($this->disk)->delete($img)){
                return true;
            }

            return false;
        }

        return false;
    }


}