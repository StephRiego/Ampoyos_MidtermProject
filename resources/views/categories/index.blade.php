@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Maze&display=swap" rel="stylesheet">

    {{-- Page Title --}}
    <h1 class="text-center mb-6" 
        style="font-family: 'Rubik Maze', sans-serif; font-size: 5rem; font-weight: 700; color: #e754a3; text-transform: uppercase;">
        ROSEREADS
    </h1>

    <h2 class="text-xl font-semibold mb-4">Categories</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-pink-100 p-4 text-pink-700">{{ session('success') }}</div>
    @endif

    {{-- Add Category Form --}}
    <form action="{{ route('categories.store') }}" method="POST" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-2">
        @csrf
        <input type="text" name="name" placeholder="Category Name" required
               class="rounded-lg border px-4 py-2 focus:ring focus:ring-pink-300">
        <input type="text" name="description" placeholder="Description"
               class="rounded-lg border px-4 py-2 focus:ring focus:ring-pink-300">
        <button type="submit" class="rounded-lg bg-pink-600 px-4 py-2 text-white hover:bg-pink-700">Add Category</button>
    </form>

    {{-- Categories Table --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Description</th>
                    <th class="border px-4 py-2">Books Count</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $category->name }}</td>
                    <td class="border px-4 py-2">{{ $category->description }}</td>
                    <td class="border px-4 py-2">{{ $category->books->count() }}</td>
                    <td class="border px-4 py-2 flex space-x-2">
                        {{-- Edit Button --}}
                        <button onclick="openEditModal({{ $category->id }})"
                                class="px-2 py-1 bg-pink-600 text-white rounded hover:bg-pink-700">Edit</button>

                        {{-- Delete Button with confirmation --}}
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{-- Edit Category Modal --}}
<div id="editModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <h3 class="text-lg font-semibold mb-4">Edit Category</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1">Name</label>
                <input type="text" name="name" id="editName" class="w-full rounded border px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Description</label>
                <input type="text" name="description" id="editDescription" class="w-full rounded border px-3 py-2">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id) {
    fetch(`/categories/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editName').value = data.name;
            document.getElementById('editDescription').value = data.description;

            const form = document.getElementById('editForm');
            form.action = `/categories/${id}`;
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        });
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}
</script>
@endsection
