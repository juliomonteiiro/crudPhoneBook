<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactService
{

    public function getAllContacts(int $userId, int $perPage = 15, int $page = 1, string $search = '', string $sortBy = 'name', string $sortOrder = 'asc')
    {
        $query = Contact::where('user_id', $userId);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Validação dos campos de ordenação permitidos
        $allowedSortFields = ['name', 'email', 'created_at'];
        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'name';
        $sortOrder = in_array(strtolower($sortOrder), ['asc', 'desc']) ? strtolower($sortOrder) : 'asc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage, ['*'], 'page', $page);
    }

    public function getContact(Contact $contact, int $userId)
    {
        $this->authorizeUser($contact, $userId);
        return $contact;
    }

    public function createContact(array $validated, int $userId, Request $request): Contact
    {
        $validated['email'] = strtolower(trim($validated['email']));
        $validated['name'] = trim($validated['name']);
        
        $contact = new Contact($validated);
        $contact->user_id = $userId;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('contacts', 'public');
            $contact->image = $path;
        }

        $contact->save();
        return $contact;
    }

    public function updateContact(Contact $contact, array $validated, int $userId, Request $request): Contact
    {
        $this->authorizeUser($contact, $userId);

        $validated['email'] = strtolower(trim($validated['email']));
        $validated['name'] = trim($validated['name']);
        
        unset($validated['image']);

        if ($request->hasFile('image')) {
            if ($contact->getRawOriginal('image')) {
                Storage::disk('public')->delete($contact->getRawOriginal('image'));
            }
            
            $path = $request->file('image')->store('contacts', 'public');
            $validated['image'] = $path;
        }

        $contact->update($validated);
        
        return $contact->fresh();
    }

    public function deleteContact(Contact $contact, int $userId): bool
    {
        $this->authorizeUser($contact, $userId);

        if ($contact->getRawOriginal('image')) {
            Storage::disk('public')->delete($contact->getRawOriginal('image'));
        }
        
        return $contact->delete();
    }

    private function authorizeUser(Contact $contact, int $userId): void
    {
        if ($contact->user_id !== $userId) {
            abort(403, 'Unauthorized');
        }
    }
}

