<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImageUpload {

    /**
     * Saves new image to public path and generates image url for database entry
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * input name from file upload field
     * @param string|null $inputName
     * 
     * parent directory name inside public_path/image folder
     * @param string $parentDirec
     * 
     * root directory name inside parent Directory folder
     * @param string|null $childDirec optional
     * 
     * intervention image fit. Default true. May be set to false if the image not to be refitted/resized
     * @param boolean $fit optional
     * 
     * output image size. default 800x800px
     * @param string|null $fitSize optional
     * 
     * default url of the picture
     * @param string|null $defaultUrl optional
     * 
     * @return image url 
     */

    public function upload(Request $request, $inputName, $parentDirec, $childDirec=null, $fit=true, $defaultUrl=null, $fitSize=null) {
        
        $image = $request->file($inputName);

        if($image == null) {
            return $defaultUrl;
        }

        if($childDirec !== null) {
            $path = 'images/' . $parentDirec . '/' . $childDirec;
        }
        else {
            $path = 'images/' . $parentDirec;
        }

        $image->storeAs($path, $image->getClientOriginalName(), 'public');

        if($fit) {
            if($fitSize !== null) {
                Image::make(public_path() . '/' . $path . '/' . $image->getClientOriginalName())->fit($fitSize);
            }
            Image::make(public_path() . '/' . $path . '/' . $image->getClientOriginalName())->fit(800, 800);
        }

        return $image->getClientOriginalName();
    }
}

?>