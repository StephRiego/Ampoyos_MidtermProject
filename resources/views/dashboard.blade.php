@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Maze&display=swap" rel="stylesheet">

    <!-- Page Title -->
    <h1 class="text-center mb-6" 
        style="font-family: 'Rubik Maze', sans-serif; font-size: 5rem; font-weight: 700; color:#e754a3 ; text-transform: uppercase;">
        ROSEREADS
    </h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="rounded-lg bg-pink-100 p-4 text-pink-700 dark:bg-pink-900/30 dark:text-pink-300 mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- ====== STAT CARDS ====== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        {{-- Total Books --}}
        <div class="rounded-xl border bg-white p-6 flex items-center justify-between dark:bg-neutral-800 dark:border-neutral-700">
            <div>
                <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Books</p>
                <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $totalBooks }}</h3>
            </div>
            <div class="rounded-full bg-pink-100 p-3 dark:bg-pink-900/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-600 dark:text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2M4 6h16M4 6v12a2 2 0 002 2h12a2 2 0 002-2V6" />
                </svg>
            </div>
        </div>

        {{-- Total Categories --}}
        <div class="rounded-xl border bg-white p-6 flex items-center justify-between dark:bg-neutral-800 dark:border-neutral-700">
            <div>
                <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Categories</p>
                <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $totalCategories }}</h3>
            </div>
            <div class="rounded-full bg-red-100 p-3 dark:bg-red-900/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h4l2 3h10a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                </svg>
            </div>
        </div>

        {{-- Most Popular Category --}}
        <div class="rounded-xl border bg-white p-6 flex items-center justify-between dark:bg-neutral-800 dark:border-neutral-700">
            <div>
                <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Most Popular Category</p>
                <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">
                    {{ $books->groupBy('category_id')->sortByDesc->count()->keys()->first() ? $categories->find($books->groupBy('category_id')->sortByDesc->count()->keys()->first())->name : 'N/A' }}
                </h3>
            </div>
            <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.122 6.517a1 1 0 00.95.69h6.853c.969 0 1.371 1.24.588 1.81l-5.544 4.03a1 1 0 00-.364 1.118l2.123 6.516c.3.921-.755 1.688-1.539 1.118l-5.544-4.03a1 1 0 00-1.176 0l-5.544 4.03c-.784.57-1.838-.197-1.539-1.118l2.123-6.516a1 1 0 00-.364-1.118L2.436 11.944c-.783-.57-.38-1.81.588-1.81h6.853a1 1 0 00.95-.69l2.122-6.517z" />
                </svg>
            </div>
        </div>

    </div>

    {{-- ====== ADD BOOK FORM ====== --}}
    <div class="mb-6 rounded-lg border border-neutral-200 bg-neutral-50 p-4 md:p-6 dark:border-neutral-700 dark:bg-neutral-900/50 max-w-3xl mx-auto">
        <h2 class="mb-3 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Add New Book</h2>
        <form action="{{ route('books.store') }}" method="POST" class="grid gap-3 md:grid-cols-2">
            @csrf
            <input type="text" name="title" placeholder="Title" class="rounded border px-2 py-1 w-full text-sm" required>
            <input type="text" name="author" placeholder="Author" class="rounded border px-2 py-1 w-full text-sm" required>
            <input type="number" name="published_year" placeholder="Year" class="rounded border px-2 py-1 w-full text-sm">
            <select name="category_id" class="rounded border px-2 py-1 w-full text-sm">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-pink-600 text-white px-3 py-1 rounded text-sm hover:bg-pink-700 col-span-2 md:col-span-1 w-full md:w-auto">Add Book</button>
        </form>
    </div>

    {{-- ====== BOOKS TABLE ====== --}}
    <div class="mt-8">
        <div class="rounded-xl border border-neutral-200 bg-white shadow-md overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-lg font-bold uppercase text-neutral-700 dark:text-neutral-300">Title</th>
                        <th class="px-6 py-3 text-left text-lg font-bold uppercase text-neutral-700 dark:text-neutral-300">Author</th>
                        <th class="px-6 py-3 text-left text-lg font-bold uppercase text-neutral-700 dark:text-neutral-300">Year</th>
                        <th class="px-6 py-3 text-left text-lg font-bold uppercase text-neutral-700 dark:text-neutral-300">Category</th>
                        <th class="px-6 py-3 text-left text-lg font-bold uppercase text-neutral-700 dark:text-neutral-300">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    @foreach($books as $book)
                    <tr class="hover:bg-neutral-100 dark:hover:bg-neutral-800 transition text-base font-semibold">
                        <td class="px-6 py-4 text-neutral-900 dark:text-neutral-100">{{ $book->title }}</td>
                        <td class="px-6 py-4 text-neutral-700 dark:text-neutral-300">{{ $book->author }}</td>
                        <td class="px-6 py-4 text-neutral-700 dark:text-neutral-300">{{ $book->published_year ?? '-' }}</td>
                        <td class="px-6 py-4 text-neutral-700 dark:text-neutral-300">{{ $book->category?->name ?? '-' }}</td>

                        <td class="px-6 py-4 flex gap-3">
                            {{-- Edit Button --}}
                            <button onclick="openBookModal({{ $book->id }}, '{{ $book->title }}', '{{ $book->author }}', {{ $book->published_year ?? 'null' }}, {{ $book->category_id ?? 'null' }})"
                                    class="text-pink-600 hover:text-pink-700 font-bold text-base">
                                Edit
                            </button>

                            {{-- Delete Button --}}
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-700 font-bold text-base">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    {{-- ====== EDIT BOOK MODAL ====== --}}
    <div id="bookModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="bg-white dark:bg-neutral-800 rounded-lg p-6 w-full max-w-md">

            <h3 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Edit Book</h3>

            <form id="bookEditForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-1">Title</label>
                    <input type="text" name="title" id="bookTitle" class="w-full rounded border px-3 py-2 text-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Author</label>
                    <input type="text" name="author" id="bookAuthor" class="w-full rounded border px-3 py-2 text-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Year</label>
                    <input type="number" name="published_year" id="bookYear" class="w-full rounded border px-3 py-2 text-sm">
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Category</label>
                    <select name="category_id" id="bookCategory" class="w-full rounded border px-3 py-2 text-sm">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeBookModal()" class="px-4 py-2 rounded border text-sm">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded bg-pink-600 text-white text-sm">Save</button>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
function openBookModal(id, title, author, year, category_id) {
    document.getElementById('bookEditForm').action = '/books/' + id;
    document.getElementById('bookTitle').value = title;
    document.getElementById('bookAuthor').value = author;
    document.getElementById('bookYear').value = year ?? '';
    document.getElementById('bookCategory').value = category_id ?? '';
    document.getElementById('bookModal').classList.remove('hidden');
    document.getElementById('bookModal').classList.add('flex');
}

function closeBookModal() {
    document.getElementById('bookModal').classList.add('hidden');
    document.getElementById('bookModal').classList.remove('flex');
}
</script>

@endsection
