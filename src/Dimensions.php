<?php 

namespace App;
use App\Cache; 

class Dimensions {
    # aspect ratio
    public int $width;
    public int $height;

    public function __construct(String $aspectRatio) {
        list($width, $height) = explode(':', $aspectRatio);

        $this->width = $width;
        $this->height = $height;

        $stepSize = Cache::get('stepSize') ?? 10;

        # create multiples of the aspect ratio to use as output sizes 
        for($i = 1; $i <= 10; $i++) {
            $outputSizes[] = [
                'width' => $this->width * $stepSize * $i,
                'height' => $this->height * $stepSize * $i
            ];
        }

        # keep data in sync
        if(isset($outputSizes)) {
            Cache::set('outputSizes', $outputSizes);
        }
    }
}