<?php
// Получаем все опубликованные биты + минимальная цена из license
$stmt = $db->query("
    SELECT 
        bit.id,
        bit.name,
        bit.autor,
        bit.obl,
        bit.mp3,
        bit.wav,
        bit.janr,
        bit.ton,
        bit.bpm,
        MIN(license.price) AS min_price
    FROM bit
    LEFT JOIN license ON bit.id = license.id_bit
    WHERE bit.status = 1
    GROUP BY bit.id
");
$bits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Биты</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap @5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css ">

    <style>
        .card-beat {
            transition: transform 0.2s ease-in-out;
            border-radius: 1rem !important;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .card-beat:hover {
            transform: scale(1.02);
        }

        .card-img-top {
            width: 100%;
            height: auto;
            object-fit: cover;
            cursor: pointer;
        }

        .beat-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #212529;
        }

        .beat-author {
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="text-center mb-4">Биты</h3>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if ($bits): ?>
            <?php foreach ($bits as $bit): ?>
                <div class="col">
                    <div class="card card-beat h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                        <!-- Обложка -->
                        <img src="<?= htmlspecialchars($bit['obl']) ?>" 
                             alt="<?= htmlspecialchars($bit['name']) ?>"
                             data-bit-id="<?= $bit['id'] ?>"
                             data-audio-src="<?= htmlspecialchars($bit['mp3']) ?>"
                             data-wav="<?= htmlspecialchars($bit['wav'] ?? '') ?>"
                             onclick="playBit(this)"
                             class="card-img-top"
                             style="height: 200px; object-fit: cover;"
                             title="Прослушать">

                        <div class="card-body d-flex flex-column">
                            <!-- Название -->
                            <a href="#" class="beat-title"><?= htmlspecialchars($bit['name']) ?></a>

                            <!-- Автор -->
                            <a href="#" class="beat-author"><?= htmlspecialchars($bit['autor']) ?></a>

                            <!-- Цена -->
                            <p class="card-text fw-bold text-success mt-2">
                                <?= isset($bit['min_price']) ? "$" . $bit['min_price'] : '<span class="text-muted">Лицензия не указана</span>' ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">Нет доступных битов</p>
        <?php endif; ?>
    </div>
</div>

<!-- Глобальный плеер -->
<div id="globalAudioPlayer" class="fixed-bottom bg-white py-3 px-4 shadow-sm border-top d-none d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
        <img id="audioCover" src="" alt="Обложка" style="width: 60px; height: 60px;" class="me-3 rounded-circle">
        <div>
            <h6 id="audioTitle">Название бита</h6>
            <small id="audioArtist">Автор</small>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3 me-3">
        <button id="togglePlayBtn" class="btn btn-success btn-sm" onclick="togglePlay()">
            <i class="fas fa-play"></i>
        </button>
        <input type="range" min="0" max="1" step="0.01" value="0.7" onchange="setVolume(this.value)" class="form-range" style="width: 100px;">
        <button class="btn btn-sm btn-outline-danger ms-3" onclick="hideAudioPlayer()">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<!-- Аудио элемент -->
<audio id="globalAudio" ontimeupdate="updateProgressBar(this)">
    <source id="currentAudioSource" src="" type="audio/mpeg">
    Ваш браузер не поддерживает аудио.
</audio>

<script>
let interactionOccurred = false;
const globalAudio = document.getElementById('globalAudio');
const sourceElement = document.getElementById('currentAudioSource');

// Первое взаимодействие пользователя
document.body.addEventListener('click', () => {
    if (!interactionOccurred) {
        interactionOccurred = true;
        console.log("Первое взаимодействие зафиксировано");
    }
}, { once: true });

// Воспроизведение бита
function playBit(element) {
    const mp3 = element.dataset.audioSrc;
    const wav = element.dataset.wav;
    const name = element.alt;
    const autor = element.closest('.card-body')?.querySelector('.beat-author')?.textContent || 'Неизвестный автор';

    // Выбираем WAV, если есть
    let audioFile = wav && wav !== 'none' ? wav : mp3;

    if (!audioFile || audioFile === 'none') {
        alert("Аудиофайл недоступен");
        return;
    }

    // Обновляем источник
    sourceElement.src = audioFile;
    globalAudio.load(); // Перезагружаем источник

    // Обновляем интерфейс плеера
    document.getElementById('audioTitle').textContent = name;
    document.getElementById('audioArtist').textContent = autor;
    document.getElementById('audioCover').src = element.src;
    document.getElementById('globalAudioPlayer').classList.remove('d-none');
    document.getElementById('globalAudioPlayer').style.display = 'flex';
    document.getElementById('togglePlayBtn').innerHTML = '<i class="fas fa-pause"></i>';

    // Запуск аудио
    if (interactionOccurred) {
        globalAudio.play().catch(err => {
            console.error("Ошибка воспроизведения:", err);
            alert("Ошибка воспроизведения. Проверьте консоль или попробуйте перезагрузить страницу.");
        });
    } else {
        alert("Сначала взаимодействуйте с сайтом");
    }
}

// Пауза / запуск
function togglePlay() {
    if (globalAudio.paused) {
        globalAudio.play();
        document.getElementById('togglePlayBtn').innerHTML = '<i class="fas fa-pause"></i>';
    } else {
        globalAudio.pause();
        document.getElementById('togglePlayBtn').innerHTML = '<i class="fas fa-play"></i>';
    }
}

// Громкость
function setVolume(volume) {
    globalAudio.volume = parseFloat(volume);
}

// Скрытие плеера
function hideAudioPlayer() {
    globalAudio.pause();
    globalAudio.currentTime = 0;
    document.getElementById('globalAudioPlayer').style.display = 'none';
}
</script>

</body>
</html>