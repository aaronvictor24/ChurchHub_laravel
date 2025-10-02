<!-- filepath: resources/views/churches/show.blade.php -->
<x-app-layout>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Church Details</h2>
        <div class="mb-2"><strong>Name:</strong> {{ $church->name }}</div>
        <div class="mb-2"><strong>Address:</strong> {{ $church->address }}</div>
        <a href="{{ route('admin.churches.index') }}" class="text-blue-600">Back to list</a>
    </div>
</x-app-layout>
