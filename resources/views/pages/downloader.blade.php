@extends("layouts.shipyard.admin")
@section("title", "Pobieracz utworu")

@section("content")

<script>
function updateLoader(progress, text, light_up_progress = undefined) {
    const progressBar = document.querySelector(".progress-bar");
    const progresses = document.querySelectorAll("[role='progress-mark']");

    progressBar.style.setProperty("--progress", `${progress}%`);
    progressBar.innerHTML = text;

    baseTitle = `Pobieracz utworu | {{ setting("app_name") }}`;
    document.title = `${text} ${progress}% | ${baseTitle}`;

    if (light_up_progress !== undefined) {
        progresses.forEach(tag => {
            if (tag.dataset.lvl <= light_up_progress) {
                tag.classList.remove("danger");
                tag.classList.add("success");
            } else if (tag.dataset.lvl < light_up_progress + 1) {
                tag.classList.add("danger");
            }
        })
    }
}

function addToQueue() {
    const detailsLoader = document.querySelector("#details .loader");

    detailsLoader.classList.remove("hidden");
    updateLoader(0, "Dodawanie do kolejki...", 0.5);

    fetch(`https://p.savenow.to/ajax/download.php?` + new URLSearchParams({
        copyright: 0,
        format: "{{ request('format', 'mp3') }}",
        url: "{{ request('link') }}",
        api: "dfcb6d76f2f6a9894gjkege8a4ab232222",
    }))
        .then(res => res.json())
        .then(res => {
            if (!res.success) throw new Error(res.error);

            console.log(res.info);

            document.querySelector(`#details .contents`).innerHTML = `
                <div class="flex down middle">
                    <img style="" src="${res.info.image}" alt="${res.info.title}">
                    <h3>${res.info.title}</h3>
                </div>
            `;

            updateLoader(0, "Pobieranie...", 1);
            startProgressTracker(res.progress_url);
        })
        .catch(err => {
            loader.innerHTML = "Błąd: " + err.message;
            console.error(err);
        });
}

function startProgressTracker(progress_url) {
    const interval = setInterval(() => {
        fetch(progress_url)
            .then(res => res.json())
            .then(res => {
                if (res.success == 1) {
                    clearInterval(interval);
                    updateLoader(100, "Gotowe!", 3);
                    window.open(res.download_url, "_blank");
                } else {
                    updateLoader(res.progress / 10, "Pobieranie...", (res.text == "Downloading" ? 2.5 : 1.5));
                }
            });
    }, 2e3);
}
</script>

<div class="grid but-mobile-down" style="--col-count: 2;">

<x-shipyard.app.section
    title="Szczegóły pliku"
    icon="information"
    id="details"
>
    <x-shipyard.app.loader />
</x-shipyard.app.section>

<x-shipyard.app.section
    title="Pobieranie"
    icon="download"
>
    <x-slot:buttons>
        <x-shipyard.ui.button
            :action="request('link')"
            label="Źródło"
            icon="open-in-new"
            target="_blank"
        />
    </x-slot:buttons>

    <x-shipyard.app.progress-bar>
        Inicjowanie...
    </x-shipyard.app.progress-bar>

    <h2 class="flex right center middle">
        <span @popper(Dodanie do kolejki) role="progress-mark" data-lvl="1" class="accent"><x-shipyard.app.icon name="tray-plus" /></span>
        <span @popper(Inicjalizacja) role="progress-mark" data-lvl="2" class="accent"><x-shipyard.app.icon name="timer-play" /></span>
        <span @popper(Przetwarzanie) role="progress-mark" data-lvl="3" class="accent"><x-shipyard.app.icon name="cog" /></span>
    </h2>
</x-shipyard.app.section>

</div>

<script defer>
addToQueue();
</script>

@endsection
