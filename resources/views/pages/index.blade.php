@extends("layouts.shipyard.admin")
@section("title", "Pobieranie utworu")

@section("content")

<x-shipyard.app.section
    title="Pobieranie"
    icon="download"
>
    <div class="flex down center">
        <div class="grid but-mobile-down center" style="--col-count: 2;">
            <x-shipyard.ui.input type="url"
                name="link"
                label="Link do youtube'a"
                icon="open-in-new"
                required
            />

            <x-shipyard.ui.input type="select"
                name="format"
                label="Format"
                icon="shape"
                required
                :select-data="[
                    'options' => [
                        ['label' => 'MP3', 'value' => 'mp3'],
                        ['label' => 'MP4', 'value' => 'mp4'],
                        ['label' => 'WAV', 'value' => 'wav'],
                    ],
                ]"
            />

        </div>

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
    const inputs = document.querySelectorAll("input, select");
    const linkInput = inputs[0];
    const formatInput = inputs[1];


    window.open(
        `{{ route('downloader') }}?` + new URLSearchParams({
            link: linkInput.value,
            format: formatInput.value,
         }),
        "_blank"
    );

    linkInput.value = "";
}
</script>

@endsection
