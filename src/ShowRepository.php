<?php
/**
 * Коршунов Георгий <georgy.k@nevosoft.ru>
 */    

namespace QuickTorrent;

class ShowRepository
{
    private $shows;

    public function __construct()
    {
        $this->shows = $this->parseFile($this->getFileName());
    }

    private function getFileName()
    {
        return "shows.json";
    }

    private function parseFile($fileName)
    {
        $fileContents = is_readable($fileName) 
            ? file_get_contents($fileName)
            : '[]';
        $showsData = json_decode($fileContents, true);
        $shows = [];
        foreach ($showsData as $showData) {
            $show = Show::fromJson($showData);
            $shows[$show->name] = $show;
        }
        return $shows;
    }

    /**
     * @return Show[]
     */
    public function findAll()
    {
        return $this->shows;
    }

    public function persist(Show $show)
    {
        $this->shows[$show->name] = $show;
    }

    public function flush()
    {
        $contents = json_encode(array_values($this->shows), JSON_PRETTY_PRINT);
        file_put_contents($this->getFileName(), $contents);
    }

    public function __destruct()
    {
        $this->flush();
    }
}
