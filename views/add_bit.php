<style>
/* Стили для навигации между шагами */
.d-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.step-header {
    cursor: pointer;
    text-align: center;
    flex: 1;
    padding: 1rem;
    background: #f8f9fa;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    transition: 0.3s;
}

.step-header.active {
    background-color: #198754;
    color: white;
    border-color: #198754;
}

.step-header:hover {
    background-color: #e9ecef;
}

.step-number {
    font-weight: bold;
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.step-title {
    font-size: 1rem;
    font-weight: 500;
}

.step-line {
    flex: 1;
    height: 2px;
    background-color: #ced4da;
    margin: 0 1rem;
}

.step {
    display: none;
}

.step.active {
    display: block;
}

.card {
    border: none;
    background-color: #f8f9fa;
}

.license-form {
    position: relative;
}

.license-form::after {
    content: attr(data-license-number);
    position: absolute;
    top: 0;
    right: 0;
    font-weight: bold;
    color: #6c757d;
}
</style>
<?php
if (!isset($_SESSION['id'])) {
    echo '<div class="alert alert-danger text-center">Для добавления бита вы должны быть авторизованы</div>';
    echo '<div class="text-center"><a href="index.php?page=auth" class="btn btn-primary">Войдите</a></div>';
    return;
}
?>

<div class="container mt-5">
    <h3 class="text-center mb-4">Добавление нового бита</h3>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <!-- Навигация между шагами -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="step-header active" data-step="1">
            <div class="step-number">1</div>
            <div class="step-title">Основное</div>
        </div>
        <div class="step-line"></div>
        <div class="step-header" data-step="2">
            <div class="step-number">2</div>
            <div class="step-title">Файлы</div>
        </div>
        <div class="step-line"></div>
        <div class="step-header" data-step="3">
            <div class="step-number">3</div>
            <div class="step-title">Лицензии</div>
        </div>
    </div>

    <!-- Многошаговая форма -->
    <form id="multiStepForm" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add_new_bit_with_licenses">

        <!-- Шаг 1: Основные данные -->
        <div class="step step-1 active">
            <div class="card shadow-sm p-4 mb-4">
                <h5>Шаг 1: Основные данные</h5>
                
                <!-- Название бита -->
                <div class="mb-3">
                    <label class="form-label">Название бита</label>
                    <input type="text" name="name" class="form-control" placeholder="Введите название бита" required>
                </div>

                <!-- Жанр -->
                <div class="mb-3">
                    <label class="form-label">Жанр</label>
                    <select name="janr" class="form-select" required>
                        <option value="">Выберите жанр</option>
                        <option value="hiphop">Hip-Hop</option>
                        <option value="trap">Trap</option>
                        <option value="lofi">Lo-Fi</option>
                        <option value="edm">EDM</option>
                        <option value="pop">Поп</option>
                    </select>
                </div>

                <!-- BPM -->
                <div class="mb-3">
                    <label class="form-label">BPM (темп)</label>
                    <input type="number" name="bpm" class="form-control" placeholder="Например: 90" required>
                </div>

                <!-- Тональность -->
                <div class="mb-3">
                    <label class="form-label">Тональность</label>
                    <select name="ton" class="form-select" required>
                        <option value="">Выберите тональность</option>
                        <option value="C">C</option>
                        <option value="G">G</option>
                        <option value="D">D</option>
                        <option value="A">A</option>
                        <option value="E">E</option>
                    </select>
                </div>

                <!-- Описание -->
                <div class="mb-3">
                    <label class="form-label">Описание бита</label>
                    <textarea name="opis" class="form-control" rows="3" maxlength="150"></textarea>
                </div>

                <!-- Переход к следующему шагу -->
                <div class="d-grid mt-4">
                    <button type="button" class="btn btn-success next-step">Файлы →</button>
                </div>
            </div>
        </div>

        <!-- Шаг 2: Файлы -->
        <div class="step step-2 d-none">
            <div class="card shadow-sm p-4 mb-4">
                <h5>Шаг 2: Загрузка файлов</h5>
                
                <!-- Обложка -->
                <div class="mb-3">
                    <label class="form-label">Обложка</label>
                    <input type="file" name="obl" accept="image/*" required>
                </div>

                <!-- MP3 файл -->
                <div class="mb-3">
                    <label class="form-label">Аудиофайл (MP3)</label>
                    <input type="file" name="mp3" accept="audio/*" required>
                    <small class="text-muted d-block mt-1">Обязательное поле</small>
                </div>

                <!-- WAV файл -->
                <div class="mb-3">
                    <label class="form-label">Дополнительный аудиофайл (WAV)</label>
                    <input type="file" name="wav" accept="audio/*">
                    <small class="text-muted d-block mt-1">Если у вас есть WAV-версия — загрузите её для полной лицензии</small>
                </div>

                <!-- Кнопки навигации -->
                <div class="d-flex gap-2 mt-4">
                    <button type="button" class="btn btn-outline-secondary prev-step">← Основное</button>
                    <button type="button" class="btn btn-success next-step ms-auto">Лицензии →</button>
                </div>
            </div>
        </div>

        <!-- Шаг 3: Лицензии -->
        <div class="step step-3 d-none">
            <div class="card shadow-sm p-4 mb-4">
                <h5>Шаг 3: Лицензии (до 4 штук)</h5>
                
                <!-- Блок лицензий -->
                <div id="licenses-container">
                    <!-- Пример одной лицензии -->
                    <div class="license-form mb-4 p-3 border rounded">
                        <h6>Лицензия 1</h6>
                        
                        <div class="row g-3">
                            <!-- Название -->
                            <div class="col-md-6">
                                <label class="form-label">Название</label>
                                <input type="text" name="licenses[0][name]" class="form-control" required>
                            </div>

                            <!-- Запись музыки -->
                            <div class="col-md-6">
                                <label class="form-label">Запись музыки</label>
                                <select name="licenses[0][zapisMus]" class="form-select" required>
                                    <option value="">Разрешено?</option>
                                    <option value="1">Да</option>
                                    <option value="0">Нет</option>
                                </select>
                            </div>

                            <!-- Коммерческие выступления -->
                            <div class="col-md-6">
                                <label class="form-label">Коммерческие выступления</label>
                                <select name="licenses[0][vistup]" class="form-select" required>
                                    <option value="">Разрешены?</option>
                                    <option value="1">Да</option>
                                    <option value="0">Нет</option>
                                </select>
                            </div>

                            <!-- Онлайн прослушивания -->
                            <div class="col-md-6">
                                <label class="form-label">Количество онлайн-прослушиваний</label>
                                <input type="number" name="licenses[0][kolPros]" class="form-control" required>
                            </div>

                            <!-- Проданные копии -->
                            <div class="col-md-6">
                                <label class="form-label">Количество проданных копий</label>
                                <input type="number" name="licenses[0][kolProdCop]" class="form-control" required>
                            </div>

                            <!-- Радиостанции -->
                            <div class="col-md-6">
                                <label class="form-label">Количество радиостанций</label>
                                <input type="number" name="licenses[0][kolRadio]" class="form-control" required>
                            </div>

                            <!-- Музыкальные видео -->
                            <div class="col-md-6">
                                <label class="form-label">Количество музыкальных видео</label>
                                <input type="number" name="licenses[0][kolVideo]" class="form-control" required>
                            </div>

                            <!-- Цена -->
                            <div class="col-md-6">
                                <label class="form-label">Цена лицензии ($)</label>
                                <input type="number" name="licenses[0][price]" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Кнопка добавления новой лицензии -->
                <div class="mb-3">
                    <button type="button" id="add-license" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-plus me-2"></i>Добавить лицензию
                    </button>
                </div>

                <!-- Кнопки навигации -->
                <div class="d-flex gap-2 mt-4">
                    <button type="button" class="btn btn-outline-secondary prev-step">← Файлы</button>
                    <button type="submit" class="btn btn-success ms-auto">Добавить бит</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
// Навигация между шагами по клику на заголовок
document.querySelectorAll('.step-header').forEach(header => {
    header.addEventListener('click', () => {
        const targetStep = header.getAttribute('data-step');
        
        // Обновляем активный шаг
        document.querySelectorAll('.step').forEach(step => {
            step.classList.add('d-none');
            step.classList.remove('active');
        });
        
        document.querySelector(`.step-${targetStep}`).classList.remove('d-none');
        document.querySelector(`.step-${targetStep}`).classList.add('active');

        // Обновляем прогресс
        document.querySelectorAll('.step-header').forEach((h, index) => {
            if (index < targetStep) {
                h.classList.add('active');
            } else {
                h.classList.remove('active');
            }
        });
    });
});

// Кнопки "Далее" и "Назад"
document.querySelectorAll('.next-step').forEach(btn => {
    btn.addEventListener('click', () => {
        const currentStep = btn.closest('.step');
        const stepNumber = parseInt(currentStep.classList[1].split('-')[1]);
        
        // Показываем следующий шаг
        const nextStep = document.querySelector(`.step-${stepNumber + 1}`);
        if (nextStep) {
            currentStep.classList.add('d-none');
            nextStep.classList.remove('d-none');
            nextStep.classList.add('active');

            // Обновляем прогресс
            document.querySelectorAll('.step-header').forEach((h, index) => {
                if (index < stepNumber + 1) {
                    h.classList.add('active');
                } else {
                    h.classList.remove('active');
                }
            });
        }
    });
});

document.querySelectorAll('.prev-step').forEach(btn => {
    btn.addEventListener('click', () => {
        const currentStep = btn.closest('.step');
        const stepNumber = parseInt(currentStep.classList[1].split('-')[1]);

        // Показываем предыдущий шаг
        const prevStep = document.querySelector(`.step-${stepNumber - 1}`);
        if (prevStep) {
            currentStep.classList.add('d-none');
            prevStep.classList.remove('d-none');
            prevStep.classList.add('active');

            // Обновляем прогресс
            document.querySelectorAll('.step-header').forEach((h, index) => {
                if (index < stepNumber - 1) {
                    h.classList.add('active');
                } else {
                    h.classList.remove('active');
                }
            });
        }
    });
});
</script>
<script>
// Добавление новых лицензий
const licensesContainer = document.getElementById('licenses-container');
const addLicenseBtn = document.getElementById('add-license');
let licenseCount = 1;

addLicenseBtn.addEventListener('click', () => {
    if (licenseCount >= 4) {
        alert("Максимум 4 лицензии");
        return;
    }

    const newLicense = document.createElement('div');
    newLicense.className = 'license-form mb-4 p-3 border rounded';
    newLicense.setAttribute('data-license-number', `Лицензия ${licenseCount + 1}`);
    newLicense.innerHTML = `
        <h6>Лицензия ${++licenseCount}</h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Название</label>
                <input type="text" name="licenses[${licenseCount - 1}][name]" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Запись музыки</label>
                <select name="licenses[${licenseCount - 1}][zapisMus]" class="form-select" required>
                    <option value="">Разрешено?</option>
                    <option value="1">Да</option>
                    <option value="0">Нет</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Коммерческие выступления</label>
                <select name="licenses[${licenseCount - 1}][vistup]" class="form-select" required>
                    <option value="">Разрешены?</option>
                    <option value="1">Да</option>
                    <option value="0">Нет</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Онлайн-прослушивания</label>
                <input type="number" name="licenses[${licenseCount - 1}][kolPros]" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Проданные копии</label>
                <input type="number" name="licenses[${licenseCount - 1}][kolProdCop]" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Количество радиостанций</label>
                <input type="number" name="licenses[${licenseCount - 1}][kolRadio]" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Количество музыкальных видео</label>
                <input type="number" name="licenses[${licenseCount - 1}][kolVideo]" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Цена лицензии ($)</label>
                <input type="number" name="licenses[${licenseCount - 1}][price]" class="form-control" required>
            </div>
        </div>
    `;
    
    licensesContainer.appendChild(newLicense);
});
</script>