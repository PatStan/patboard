@csrf

<h1 class="text-2xl font-normal mb-10 text-center">
    {{ $title }}
</h1>
<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="title">Title</label>

    <div class="control">
        <input
            type="text"
            class="input bg-transparent border border-gray-300 rounded p-2 text-xs w-full"
            name="title"
            placeholder="Project title..."
            value="{{ $project->title }}"
            required
        >
    </div>
</div>

<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="description">Description</label>

    <div class="control">
                <textarea
                    name="description"
                    rows="10"
                    class="textarea bg-transparent border border-gray-300 rounded p-2 text-xs w-full"
                    placeholder="Project description..."
                    required
                >{{ $project->description }}</textarea>
    </div>
</div>

<div class="field">
    <div class="control">
        <button type="submit" class="button is-link">{{ $project->exists ? 'Update' : 'Create' }} Project</button>
        <a href="{{ $project->path() }}" class="button bg-gray-400 hover:bg-gray-500 float-right pt-2">Cancel</a>
    </div>
</div>

@if ($errors->any())
    <div class="field mt-4">
        @foreach($errors->all() as $error)
            <li class="text-sm text-red-500">{{ $error }}</li>
        @endforeach
    </div>
@endif
