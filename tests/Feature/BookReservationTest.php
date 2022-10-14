<?php

namespace Tests\Feature;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    /** @test */
    use RefreshDatabase;
    public function a_book_can_be_added_to_library(){

        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'Cool book title',
            'author' => 'Romuel'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());

    }

    /** @test */
    public function title_is_required(){

        // $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Romuel'
        ]);

        $response->assertSessionHasErrors('title');

    }
    /** @test */
    public function author_is_required(){

        // $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'Cool book title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');

    }

    /** @test */
    public function a_book_can_be_updated(){

        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'Cool book title',
            'author' => 'Romuel'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/'.$book->id, [ 
            'title' => 'New Title',
            'author' => 'New Author'
        ]);
        

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);

    }
}
