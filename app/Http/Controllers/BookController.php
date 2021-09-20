<?php

namespace App\Http\Controllers;

use App\Models\Book;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(Request $request, $bookId = '') {

        /* Filtrando os livros pelos campos:
            title
            description
            author
            pages
            registration_at
        */

        $input = $request->only('filter');

        if (!empty($input['filter'])) {
            $filter = $input['filter'];
            $date = (DateTime::createFromFormat('d/m/Y', $filter));
            $filterDate = ($date) ? $date->format('Y-m-d') : '';

            $books = Book::where('title', 'like', "%$filter%")
                ->orWhere('author', 'like', "%$filter%")
                ->orWhere('description', 'like', "%$filter%")
                ->orWhere('registration_at', '=', $filterDate)
                ->orderBy('id', 'desc')->simplePaginate(10);
        } else {
            $books = (empty($bookId)) ? Book::orderBy('id', 'desc')->simplePaginate(10) : Book::find($bookId);
        }

        if (empty($books)) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum livro encontrado.'
            ]);
        }

        return response()->json($books);
    }

    public function create(Request $request) {
        $input = $request->only(
            'title',
            'description',
            'author',
            'pages',
            'registration_at',
        );

        $validator = $this->createInputValidator($input);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $created = Book::create($input);

        if (!$created) {
            return response()->json([
                'success' => false,
                'message' => 'Falha no cadastrado do livro'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Livro cadastrado com sucesso'
        ]);
    }

    public function update(Request $request, $bookId) {
        $input = $request->only(
            'title',
            'description',
            'author',
            'pages',
            'registration_at',
        );

        if (!Book::find($bookId)) {
            return response()->json([
                'success' => false,
                'errors' => 'O livro informado não existe',
            ]);
        }
        
        $validator = $this->createInputValidator($input);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $updated = Book::where(['id' => $bookId])->update($input);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao alterar do livro'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Livro alterado com sucesso'
        ]);
    }

    public function delete($bookId) {
        $deleted = Book::where(['id' => $bookId])->delete();

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao apagar do livro'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Livro apagado com sucesso'
        ]);
    }

    public function createInputValidator($input) {
        $validator = Validator::make($input, [
            'title'             => 'required|max:255',
            'description'       => 'required|max:500',
            'author'            => 'required|max:255',
            'pages'             => 'required|numeric',
            'registration_at'   => 'required|date',
        ], [
            'title.unique'      => 'Já existe um livro com este título'
        ], [
            'title'             => 'Título',
            'description'       => 'Descrição',
            'author'            => 'Autor',
            'pages'             => 'Número de Páginas',
            'registration_at'   => 'Data de Cadastro',
        ]);

        return $validator;
    }
}
