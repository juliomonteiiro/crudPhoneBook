<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        $contacts = $this->contactService->getAllContacts(
            $request->user()->id,
            $perPage,
            $page,
            $search,
            $sortBy,
            $sortOrder
        );
        
        return response()->json([
            'status' => 'success',
            'data' => $contacts->items(),
            'pagination' => [
                'current_page' => $contacts->currentPage(),
                'last_page' => $contacts->lastPage(),
                'per_page' => $contacts->perPage(),
                'total' => $contacts->total(),
                'from' => $contacts->firstItem(),
                'to' => $contacts->lastItem(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10,11}$/',
            'email' => 'required|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 2 caracteres.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'phone.required' => 'O telefone é obrigatório.',
            'phone.regex' => 'O telefone deve conter apenas números e ter 10 ou 11 dígitos.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço válido.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
            'image.image' => 'O arquivo deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg ou gif.',
            'image.max' => 'A imagem não pode ter mais de 2MB.',
        ]);

        $contact = $this->contactService->createContact(
            $validated,
            $request->user()->id,
            $request
        );
        
        return response()->json([
            'status' => 'success',
            'data' => $contact
        ], 201);
    }

    public function show(Contact $contact, Request $request)
    {
        $contact = $this->contactService->getContact($contact, $request->user()->id);
        
        return response()->json([
            'status' => 'success',
            'data' => $contact
        ]);
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'phone' => 'required|string|regex:/^[0-9]{10,11}$/',
            'email' => 'required|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 2 caracteres.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'phone.required' => 'O telefone é obrigatório.',
            'phone.regex' => 'O telefone deve conter apenas números e ter 10 ou 11 dígitos.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço válido.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
            'image.image' => 'O arquivo deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg ou gif.',
            'image.max' => 'A imagem não pode ter mais de 2MB.',
        ]);

        $contact = $this->contactService->updateContact(
            $contact,
            $validated,
            $request->user()->id,
            $request
        );
        
        return response()->json([
            'status' => 'success',
            'data' => $contact
        ]);
    }

    public function destroy(Contact $contact, Request $request)
    {
        $this->contactService->deleteContact($contact, $request->user()->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Contato removido com sucesso'
        ]);
    }
}
