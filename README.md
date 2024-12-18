# Pixelate API 

Command line tool to create pixel art from images. Currently work in progress but basic features are working.

## how it works 
After an input file is selected using ImageMagick the file is first scaled down to a small size somewhere in the two digit range. 
This is simulating pixelation while a point filer prevents bleeding to create chunky blocks. Finally the image gets scaled up again to achive a high quality result while retaining the pixel art look. 

## Implemented features: 
- generate pixel art from input image file 
- choose output aspect ratio
- choose output file size 
- choose from multiple files 

## todos 
- choose size of the first step downscaled image as that can hugely effect the look of the final product
- iteratively create multiple versions with different settings at once to make choosing the best version easier
- create a chain of all needed setup commands to make first use easier 

## how to use 
This CLI is relying on Symfony's command component to create an interactive experience. You'll need php and composer setup on your machine.

Install ImageMagick on your machine and make it available through ``convert``. 

Install dependencies: 
``` 
composer install 
``` 

run: 
``` 
php src/run.php
``` 

setup alias: 
``` 
alias pixelate='php /path/to/project/src/run.php'
```
