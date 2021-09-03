<?php

namespace App\Services;

use App\Repositories\AuthorRepositoryInterface;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\GenreRepositoryInterface;

class BookService
{
    protected $bookRepository;
    protected $authorRepository;

    public function __construct(
        BookRepositoryInterface $bookRepository,
        AuthorRepositoryInterface $authorRepository,
        GenreRepositoryInterface $genreRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
        $this->genreRepository = $genreRepository;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getBook($id)
    {
        return $this->bookRepository->findById($id);
    }

    public function getAllBook()
    {
        return $this->bookRepository->all();
    }

    public function addBook(array $bookInfo)
    {
        $book = $this->bookRepository->create([
            "title" => $bookInfo["title"],
            "description" => $bookInfo["description"],
            "cover_image" => $bookInfo["coverImage"] ?? null,
            "qty" => $bookInfo["qty"] ?? 1
        ]);

        $authorIds = $this->storeRelationAndGetIds($bookInfo["authors"], $this->authorRepository);
        $book->authors()->sync($authorIds);

        $genreIds = $this->storeRelationAndGetIds($bookInfo["genres"], $this->genreRepository);
        $book->genres()->sync($genreIds);

        return $book;
    }

    public function updateBook(array $bookInfo, $id)
    {
        $book = [
            "title" => $bookInfo["title"],
            "description" => $bookInfo["description"],
            "cover_image" => $bookInfo["coverImage"] ?? null,
            "qty" => $bookInfo["qty"] ?? 1
        ];

        $book = $this->bookRepository->update($id, $book);
        $authorIds = $this->storeRelationAndGetIds($bookInfo["authors"], $this->authorRepository);
        $book->authors()->sync($authorIds);

        $genreIds = $this->storeRelationAndGetIds($bookInfo["genres"], $this->genreRepository);
        $book->genres()->sync($genreIds);

        return $book;
    }


    private function storeRelationAndGetIds(string $commaSeparatedString, $repository)
    {
        $items = explode(",", $commaSeparatedString);
        $ids = [];
        foreach ($items as $itemName)
        {
            $item = $repository->firstOrCreate(["name" => $itemName]);
            $ids[] = $item->id;
        }
        return $ids;
    }

    public function deleteBook($id)
    {
        $this->bookRepository->delete($id);
    }
}
