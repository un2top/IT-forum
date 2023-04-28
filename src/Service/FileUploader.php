<?php

namespace App\Service;

use League\Flysystem\FilesystemInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{

    /**
     * @var SluggerInterface
     */
    private $slugger;
    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    public function __construct(FilesystemInterface $articleFileSystem, SluggerInterface $slugger)
    {

        $this->slugger = $slugger;
        $this->filesystem = $articleFileSystem;
    }

    public function uploadFile(File $file, ?string $oldFileName = null): string
    {
        $filename = $this->slugger
            ->slug(pathinfo($file instanceof UploadedFile ? $file->getClientOriginalName() : $file->getFilename(), PATHINFO_FILENAME))
            ->append('-' . uniqid())
            ->append('.' . $file->guessExtension())
            ->toString();
//        $newFile = $file->move($this->uploadsPath, $filename);
        $stream = fopen($file->getPathname(), 'r');
        $result = $this->filesystem->writeStream($filename, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }
        if (! $result){
            throw new \Exception("Не удалось записать файл: $filename");
        }
        if ($oldFileName && $this->filesystem->has($oldFileName)){
            $result = $this->filesystem->delete($oldFileName);
            if (! $result){
                throw new \Exception("Не удалось удалить файл: $oldFileName");
            }
        }
        return $filename;
    }

}