let balance = 0;
const photoContainer = document.getElementById("photo-container");
const balanceDisplay = document.getElementById("balance");
let currentIndex = 0;
let photos = [];
let isLoading = false;
let history = [];
let timerInterval;
let likedPhotos = 0;
let totalEarned = 0;
let withdrawalCount = 0;

// List of random female names for the models
const modelNames = [
    "Sofia", "Isabella", "Valentina", "Luísa", "Helena", "Maria", "Júlia", 
    "Alice", "Laura", "Manuela", "Gabriela", "Beatriz", "Mariana", "Clara", 
    "Cecília", "Lara", "Heloísa", "Giovanna", "Elisa", "Melissa", "Ana", 
    "Nicole", "Rafaela", "Larissa", "Bianca", "Fernanda", "Carolina", "Amanda", 
    "Natália", "Letícia", "Marina", "Vitória", "Lívia", "Daniela", "Bruna", 
    "Camila", "Bárbara", "Eduarda", "Yasmin", "Isabela", "Rebeca", "Raquel", 
    "Stella", "Juliana", "Renata", "Tatiana", "Patrícia", "Priscila", "Vanessa", 
    "Débora", "Sabrina", "Paloma", "Cristina", "Viviane", "Flávia", "Luciana", 
    "Paula", "Carla", "Diana", "Monica", "Teresa", "Verônica", "Olivia", "Joana"
];

function formatCurrency(value) {
    return parseFloat(value).toFixed(2).replace('.', ',');
}

function getRandomValue(min, max) {
    return (Math.random() * (max - min) + min).toFixed(2);
}

function showToast(message, isSuccess = true) {
    const toast = document.getElementById("toast");
    toast.textContent = message;
    toast.style.display = "block";
    toast.className = "toast " + (isSuccess ? "success-toast" : "error-toast");
    
    setTimeout(() => {
        toast.style.display = "none";
    }, 3000);
}

function generateRandomModelName() {
    return modelNames[Math.floor(Math.random() * modelNames.length)];
}

function generatePhotos() {
    showLoading();
    
    setTimeout(() => {
        for (let i = 0; i < 15; i++) {
            let isGolden = Math.random() < 0.2; // 20% chance of being golden
            let value = isGolden ? getRandomValue(75, 125) : getRandomValue(15, 50);
            let randomId = Math.floor(Math.random() * 10000);
            let modelName = generateRandomModelName();
            let photo = {
                url: `https://source.unsplash.com/random/600x800?model,woman,portrait,${randomId}`,
                value: value,
                isGolden: isGolden,
                name: modelName,
                age: Math.floor(Math.random() * 10) + 20 // Random age between 20-29
            };
            photos.push(photo);
        }
        
        hideLoading();
        showPhoto();
    }, 1500);
}

function showLoading() {
    isLoading = true;
    photoContainer.innerHTML = `
        <div class="loading">
            <i class="fas fa-spinner"></i>
        </div>
    `;
}

function hideLoading() {
    isLoading = false;
}

function showPhoto() {
    if (isLoading) return;
    
    if (currentIndex >= photos.length) {
        photoContainer.innerHTML = `
            <div class="end-message">
                <h3><i class="fas fa-check-circle"></i> Fotos Concluídas!</h3>
                <p>Você visualizou todas as fotos disponíveis por enquanto</p>
                <button onclick="refreshPhotos()"><i class="fas fa-sync-alt"></i> Buscar Mais Fotos</button>
            </div>
        `;
        return;
    }
    
    const currentPhoto = photos[currentIndex];
    const photoClass = currentPhoto.isGolden ? "photo-container golden-border" : "photo-container";
    
    photoContainer.innerHTML = `
        <div class="${photoClass}">
            ${currentPhoto.isGolden ? '<div class="golden-badge"><i class="fas fa-star"></i> Premium</div>' : ''}
            <div class="photo">
                <img src="${currentPhoto.url}" alt="Foto para curtir">
                <div class="model-info">
                    <span class="model-name">${currentPhoto.name}, ${currentPhoto.age}</span>
                </div>
            </div>
            <div class="photo-info">
                <div class="photo-value">
                    <i class="fas fa-coins"></i> Valor: R$ ${formatCurrency(currentPhoto.value)}
                </div>
                <div class="action-buttons">
                    <button class="button like-btn" onclick="likePhoto()">
                        <i class="fas fa-thumbs-up"></i> Curtir
                    </button>
                    <button class="button skip-btn" onclick="skipPhoto()">
                        <i class="fas fa-forward"></i> Pular
                    </button>
                </div>
            </div>
        </div>
    `;
}

function likePhoto() {
    if (currentIndex >= photos.length) return;
    
    const currentPhoto = photos[currentIndex];
    const earnedValue = parseFloat(currentPhoto.value);
    
    // Add value to balance
    balance += earnedValue;
    balanceDisplay.textContent = formatCurrency(balance);
    
    // Increment liked photos count
    likedPhotos++;
    
    // Add to total earned
    totalEarned += earnedValue;
    
    // Update profile stats if elements exist
    updateProfileStats();
    
    // Add to history
    const now = new Date();
    const historyItem = {
        type: 'earning',
        amount: earnedValue,
        description: `Curtida na foto de ${currentPhoto.name}`,
        date: now.toLocaleDateString(),
        time: now.toLocaleTimeString()
    };
    history.push(historyItem);
    updateHistoryList();
    
    // Show toast
    showToast(`R$ ${formatCurrency(earnedValue)} adicionado ao seu saldo!`);
    
    // Move to next photo
    currentIndex++;
    showPhoto();
}

function skipPhoto() {
    currentIndex++;
    showPhoto();
}

function refreshPhotos() {
    photos = [];
    currentIndex = 0;
    generatePhotos();
}

function updateHistoryList() {
    const historyList = document.getElementById("history-list");
    if (!historyList) return;
    
    historyList.innerHTML = '';
    
    if (history.length === 0) {
        historyList.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-history"></i>
                <p>Ainda não há transações em seu histórico</p>
            </div>
        `;
        return;
    }
    
    // Show history in reverse order (most recent first)
    for (let i = history.length - 1; i >= 0; i--) {
        const item = history[i];
        const isCredit = item.type === 'earning';
        
        historyList.innerHTML += `
            <div class="history-item">
                <div class="history-icon ${isCredit ? 'credit-icon' : 'debit-icon'}">
                    <i class="${isCredit ? 'fas fa-thumbs-up' : 'fas fa-money-bill-transfer'}"></i>
                </div>
                <div class="history-details">
                    <div class="history-title">${item.description}</div>
                    <div class="history-date">${item.date} às ${item.time}</div>
                </div>
                <div class="history-amount ${isCredit ? 'credit' : 'debit'}">
                    ${isCredit ? '+' : '-'} R$ ${formatCurrency(item.amount)}
                </div>
            </div>
        `;
    }
}

function updateProfileStats() {
    // Verifica se os elementos existem antes de atualizá-los
    const likedPhotosElement = document.querySelector('.profile-stat:nth-child(1) h4');
    const totalEarnedElement = document.querySelector('.profile-stat:nth-child(2) h4');
    const withdrawalsElement = document.querySelector('.profile-stat:nth-child(3) h4');
    
    if (likedPhotosElement) likedPhotosElement.textContent = likedPhotos;
    if (totalEarnedElement) totalEarnedElement.textContent = `R$${formatCurrency(totalEarned)}`;
    if (withdrawalsElement) withdrawalsElement.textContent = withdrawalCount;
}

function showQrCodeModal() {
    const withdrawAmountInput = document.getElementById("withdraw-amount");
    const withdrawValue = parseFloat(withdrawAmountInput.value);
    
    if (isNaN(withdrawValue) || withdrawValue < 10) {
        showToast("O valor mínimo para saque é R$ 10,00", false);
        return;
    }
    
    if (withdrawValue > balance) {
        showToast("Saldo insuficiente para este saque", false);
        return;
    }
    
    const fee = withdrawValue * 0.1; // 10% fee
    const finalValue = withdrawValue - fee;
    
    document.getElementById("modal-amount").textContent = `R$ ${formatCurrency(withdrawValue)}`;
    document.getElementById("modal-fee").textContent = `R$ ${formatCurrency(fee)}`;
    document.getElementById("modal-final").textContent = `R$ ${formatCurrency(finalValue)}`;
    
    const qrCodeModal = document.getElementById("qrcode-modal");
    qrCodeModal.style.display = "flex";
    
    // Start timer
    let timeLeft = 600; // 10 minutes in seconds
    updateTimer(timeLeft);
    
    if (timerInterval) {
        clearInterval(timerInterval);
    }
    
    timerInterval = setInterval(() => {
        timeLeft--;
        updateTimer(timeLeft);
        
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            closeQrCodeModal();
            showToast("Tempo para pagamento expirado", false);
        }
    }, 1000);
}

function updateTimer(seconds) {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = seconds % 60;
    document.getElementById("qr-timer").textContent = 
        `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
}

function closeQrCodeModal() {
    const qrCodeModal = document.getElementById("qrcode-modal");
    qrCodeModal.style.display = "none";
    
    if (timerInterval) {
        clearInterval(timerInterval);
    }
}

function processPayment() {
    const withdrawAmountInput = document.getElementById("withdraw-amount");
    const withdrawValue = parseFloat(withdrawAmountInput.value);
    
    if (isNaN(withdrawValue) || withdrawValue <= 0) return;
    
    // Add to history
    const now = new Date();
    const historyItem = {
        type: 'withdrawal',
        amount: withdrawValue,
        description: 'Saque processado',
        date: now.toLocaleDateString(),
        time: now.toLocaleTimeString()
    };
    history.push(historyItem);
    
    // Update balance
    balance -= withdrawValue;
    balanceDisplay.textContent = formatCurrency(balance);
    
    // Increment withdrawals count
    withdrawalCount++;
    
    // Update profile stats
    updateProfileStats();
    
    // Update history
    updateHistoryList();
    
    // Close modal and show message
    closeQrCodeModal();
    showToast("Saque realizado com sucesso! Aguarde o processamento.");
    document.getElementById("withdraw-amount").value = "";
}

// Navigation between sections
function setupNavigation() {
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all items and sections
            document.querySelectorAll('.nav-item').forEach(navItem => {
                navItem.classList.remove('active');
            });
            
            document.querySelectorAll('.app-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // Show corresponding section
            const sectionId = this.getAttribute('data-section');
            document.getElementById(sectionId).classList.add('active');
        });
    });
}

// Initialize the app
window.onload = function() {
    generatePhotos();
    updateHistoryList();
    updateProfileStats();
    setupNavigation();
};