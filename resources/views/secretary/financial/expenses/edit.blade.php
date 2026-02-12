@extends('layouts.secretary')

@section('content')
    <div class="p-6 bg-gray-900 min-h-screen text-white">
        <h1 class="text-2xl font-bold mb-6">Edit Expense</h1>
        <form action="{{ route('secretary.expenses.update', $expense->id) }}" method="POST"
            class="bg-gray-800 rounded-xl p-6 border border-white/10 shadow max-w-lg mx-auto">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block mb-2 font-semibold">Amount</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount', $expense->amount) }}" required
                    class="w-full p-2 rounded bg-gray-700 text-white" placeholder="0.00">
                @error('amount')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-semibold">Date</label>
                <input type="date" name="expense_date" value="{{ old('expense_date', $expense->expense_date) }}" required
                    class="w-full p-2 rounded bg-gray-700 text-white">
                @error('expense_date')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-semibold">Purpose</label>
                <select name="purpose" class="w-full p-2 rounded bg-gray-700 text-white">
                    <option value="">-- Select purpose --</option>
                    @foreach ($purposes as $p)
                        <option value="{{ $p }}"
                            {{ old('purpose', $expense->purpose ?? '') == $p ? 'selected' : '' }}>{{ $p }}
                        </option>
                    @endforeach
                </select>
                @error('purpose')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-2">Requested By</label>
                <input type="text" name="requested_by" value="{{ old('requested_by', $expense->requested_by ?? '') }}"
                    class="w-full p-2 rounded bg-gray-700 text-white" placeholder="Name">
                @error('requested_by')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-2">Released To</label>
                <input type="text" name="released_to" value="{{ old('released_to', $expense->released_to ?? '') }}"
                    class="w-full p-2 rounded bg-gray-700 text-white" placeholder="Name">
                @error('released_to')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-2">Details</label>
                <textarea name="description" rows="5" class="w-full p-2 rounded bg-gray-700 text-white" placeholder="Details">{{ old('description', $expense->description) }}</textarea>
                @error('description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-lg font-semibold">Save</button>
            <a href="{{ route('secretary.expenses.index') }}" class="ml-4 text-gray-300 hover:underline">Cancel</a>
        </form>
    </div>
@endsection
