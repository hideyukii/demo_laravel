<?php


namespace App\Lib\RepositorySupports;


class FileStore
{
    /** @var FileSystem */
    private $files;

    public function __construct()
    {
        $this->files = new FileSystem();
    }

    public function get($id, $key)
    {
        $filePath = $this->fileFullPathFromId($id);
        if (!$this->files->exists($filePath)) {
            return null;
        }

        $data = $this->files->get($filePath);
        $array = unserialize($data);

        if (!array_key_exists($key, $array)) {
            return null;
        }

        return $array[$key];
    }

    public function getAll($id)
    {
        $filePath = $this->fileFullPathFromId($id);
        if (!$this->files->exists($filePath)) {
            return array();
        }

        $data = $this->files->get($filePath);
        $array = unserialize($data);

        return $array;
    }

    /**
     * @param $id なぜか保存用のフルパスとファイル名
     * @param $key なぜかID
     * @param $key ドメインオブジェクト
     */
    public function put($id, $key, $data)
    {
        // ディレクトリが存在しなければ作成
        $this->ensureDirectoryExists($this->directoryFullPath());
        // ファイル名（パスも）を生成
        $filePath = $this->fileFullPathFromId($id);
        // ファイルが存在する場合
        if ($this->files->exists($filePath)) {
            $savedData = $this->files->get($filePath);
            $array = unserialize($savedData);
        } else {
            $array = array();
        }
        // 配列に変換
        $array[$key] = $data;
        // さらにシリアライズ
        $serialized = serialize($array);

        $this->ensureDirectoryExists(dirname($filePath));
        $this->files->put($filePath, $serialized);
    }

    private function ensureDirectoryExists(string $path)
    {
        if (!$this->files->exists($path)) {
            $this->files->makeDirectory($path, @755, true);
        }
    }

    private function fileFullPathFromId(string $filePath)
    {
        return $this->directoryFullPath() . "\\" . $filePath . ".dat";
    }

    private function directoryFullPath()
    {
        $basicDirectoryPath = FileRepositoryConfig::$basicDirectoryFullPath;
        $basicDirectoryPath = str_replace('\\', '/', $basicDirectoryPath);
        return $basicDirectoryPath;
    }
}
