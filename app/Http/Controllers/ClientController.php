<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index() {

        $client = Client::orderBy('id')
                ->orderBy('last_name')->get();

        return response()->json($client);
    }

    public function view(Client $client) {

        return response()->json([
            'status' => 'OK',
            'data' => $client,
        ]);
    }

    public function store(Request $request) {
        $fields = $request->validate([
            'last_name' => 'required| string',
            'first_name' => 'required| string',
            'address' => 'required| string',
            'phone' => 'required| string',
            'email' => 'required| string',
            'sex' => 'required| string',
            'birth_date' => 'required| date',
            'max_credit' => 'required|numeric|between:0,9999999999.99',
        ]);
        $client =Client::create($fields);

        return response()->json([
            'status' => 'OK',
            'message' => 'A new student is added with an id#:' . $client->id
        ]);
    }

    public function destroy($id)
    {
        // Find the client by ID
        $client = Client::findOrFail($id);

        // Delete the client
        $client->delete();

        return response()->json([
            'status' => 'OK',
            'message' => 'Client deleted successfully',
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'email' => 'required| string',
            'sex' => 'required| string',
            'birth_date' => 'required| date',
            'max_credit' => 'required|numeric|between:0,9999999999.99',

        ]);

        // Find the client by ID
        $client = Client::findOrFail($id);

        // Update the client details
        $client->update($request->all());

        return response()->json([
            'status' => 'OK',
            'message' => 'Client updated successfully',
            'data' => $client,
        ]);
    }
}


