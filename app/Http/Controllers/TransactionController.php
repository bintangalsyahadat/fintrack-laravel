<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Http\Resources\TransactionResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = Transactions::where('user_id', Auth::id())
            ->with('category')
            ->latest('date')
            ->get();

        if ($request->wantsJson()) {
            return TransactionResource::collection($transactions);
        }

        return view('pages.transactions', compact('transactions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount'       => 'required|numeric|min:0',
            'type'         => 'required|in:income,expense',
            'description'  => 'nullable|string|max:255',
            'date'         => 'required|date',
            'category_id'  => 'nullable|exists:categories,id',
        ]);

        try {
            $transaction = Transactions::create([
                ...$validated,
                'user_id' => Auth::id(),
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Transaction created successfully',
                    'data'    => new TransactionResource($transaction)
                ], 201);
            }

            return redirect()
                ->route('web.transactions.index')
                ->with('success', 'Transaction created successfully');
        } catch (Exception $e) {

            return $this->errorResponse($request, 'Failed to create transaction');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $transaction = $this->findAuthorizedTransaction($id);
        if (!$transaction) {
            return $this->notFoundResponse($request);
        }

        if ($request->wantsJson()) {
            return new TransactionResource($transaction);
        }

        return view('pages.transactions.show', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaction = $this->findAuthorizedTransaction($id);
        if (!$transaction) {
            return $this->notFoundResponse($request);
        }

        $validated = $request->validate([
            'amount'       => 'required|numeric|min:0',
            'type'         => 'required|in:income,expense',
            'description'  => 'nullable|string|max:255',
            'date'         => 'required|date',
            'category_id'  => 'nullable|exists:categories,id',
        ]);

        try {
            $transaction->update($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Transaction updated successfully',
                    'data'    => new TransactionResource($transaction)
                ]);
            }

            return redirect()
                ->route('web.transactions.index')
                ->with('success', 'Transaction updated successfully');
        } catch (Exception $e) {
            return $this->errorResponse($request, 'Failed to update transaction');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $transaction = $this->findAuthorizedTransaction($id);
        if (!$transaction) {
            return $this->notFoundResponse($request);
        }

        try {
            $transaction->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Transaction deleted successfully'
                ]);
            }

            return redirect()
                ->route('web.transactions.index')
                ->with('success', 'Transaction deleted successfully');
        } catch (Exception $e) {
            return $this->errorResponse($request, 'Failed to delete transaction');
        }
    }

    /**
     * Find transaction and ensure it belongs to authenticated user
     */
    private function findAuthorizedTransaction(string $id): ?Transactions
    {
        return Transactions::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
    }

    private function notFoundResponse(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        return back()->withErrors('Transaction not found');
    }

    private function errorResponse(Request $request, string $message)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => $message
            ], 500);
        }

        return back()->withErrors($message);
    }
}
