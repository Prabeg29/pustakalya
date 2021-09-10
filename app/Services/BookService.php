<?php

namespace App\Services;

use App\Models\Book;
use App\Repositories\AuthorRepositoryInterface;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\GenreRepositoryInterface;

class BookService
{
    protected $bookRepository;
    protected $authorRepository;
    protected $genreRepository;

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

    /**
     * @return \Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAllBooks()
    {
        return $this->bookRepository->all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAllBooksPaginated()
    {
        return $this->bookRepository->paginate();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAllApprovedBooksPaginated()
    {
        return $this->bookRepository->allApprovedBooksPaginated('is_approved', 1);
    }

    /**
     * @param array $bookInfo
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function addBook(array $bookInfo)
    {
        $book = $this->bookRepository->create([
            "title" => $bookInfo["title"],
            "description" => $bookInfo["description"],
            "cover_image" => $bookInfo["coverImage"] ?? null,
            "is_approved" => $bookInfo["isApproved"] ?? false
        ]);

        $authorIds = $this->storeRelationAndGetIds($bookInfo["authors"], $this->authorRepository);
        $book->authors()->sync($authorIds);

        $genreIds = $this->storeRelationAndGetIds($bookInfo["genres"], $this->genreRepository);
        $book->genres()->sync($genreIds);

        return $book;
    }

    /**
     * @param array $bookInfo
     * @param $id
     * @return array|bool|\Illuminate\Database\Eloquent\Model|null
     */
    public function updateBook(array $bookInfo, $id)
    {
        $book = [
            "title" => $bookInfo["title"],
            "description" => $bookInfo["description"],
            "cover_image" => $bookInfo["coverImage"] ?? null,
            "is_approved" => $bookInfo["isApproved"] ?? false
        ];

        $book = $this->bookRepository->update($id, $book);
        $authorIds = $this->storeRelationAndGetIds($bookInfo["authors"], $this->authorRepository);
        $book->authors()->sync($authorIds);

        $genreIds = $this->storeRelationAndGetIds($bookInfo["genres"], $this->genreRepository);
        $book->genres()->sync($genreIds);

        return $book;
    }


    /**
     * @param string $commaSeparatedString
     * @param $repository
     * @return array
     */
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

    /**
     * @param $id
     */
    public function deleteBook($id)
    {
        return $this->bookRepository->delete($id);
    }

    public function searchForApprovedBooks(string $search)
    {
        $results = Book::with(['authors',  'genres'])
            ->where('is_approved', '=', '1')
            ->where('title', 'like', "%$search%")
            ->orWhere(function($query) use ($search) {
                $query->whereHas('authors', function($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
            })
            ->orWhere(function($query) use ($search){
                $query->whereHas('genres', function($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
            })
            ->get();

        return $results;
    }
}
