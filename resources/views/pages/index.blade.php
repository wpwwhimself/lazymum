@extends("layouts.shipyard.admin")
@section("title", "Pobieranie utworu")

@section("content")

<x-shipyard.app.section
    title="Pobieranie"
    icon="download"
>
    <div class="flex down center">
        <x-shipyard.ui.input type="url"
            name="link"
            label="Link do youtube'a"
            icon="open-in-new"
            required
        />

        <x-shipyard.ui.button
            label="Pobierz"
            icon="download"
            action="none"
            onclick="goToDownloader()"
            class="primary"
        />
    </div>

</x-shipyard.app.section>

<script>
function goToDownloader() {
    const linkInput = document.querySelector("input[name='link']");
    const link = linkInput.value;

    window.open(
        `{{ route('downloader') }}?link=${link}`,
        "_blank"
    );

    linkInput.value = "";
}
</script>

@endsection
