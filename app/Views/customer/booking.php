<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto">
    <div class="mb-6 md:mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Booking Layanan</h1>
        <p class="text-sm md:text-base text-gray-600">Pilih hairstyle dan jadwal yang sesuai untuk Anda</p>
    </div>

    <form action="/booking" method="POST" class="space-y-8">
        <!-- Hairstyle Selection -->
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6">
            <h2 class="text-lg md:text-xl font-semibold mb-4">Pilih Hairstyle</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($hairstyles as $hairstyle): ?>
                    <div class="border-2 rounded-lg p-4 cursor-pointer hover:border-accent transition-colors hairstyle-option <?= ($selected_hairstyle && $selected_hairstyle['id'] == $hairstyle['id']) ? 'border-accent bg-yellow-50' : 'border-gray-200' ?>" 
                         data-id="<?= $hairstyle['id'] ?>" 
                         data-price="<?= $hairstyle['price'] ?>"
                         data-name="<?= $hairstyle['name'] ?>">
                        <div class="h-32 bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                            <?php if ($hairstyle['image']): ?>
                                <img src="/<?= $hairstyle['image'] ?>" alt="<?= $hairstyle['name'] ?>" class="w-full h-full object-cover rounded-lg">
                            <?php else: ?>
                                <i class="fas fa-cut text-4xl text-gray-400"></i>
                            <?php endif; ?>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1"><?= $hairstyle['name'] ?></h3>
                        <p class="text-sm text-gray-600 mb-2"><?= $hairstyle['description'] ?></p>
                        <p class="text-lg font-bold text-accent">Rp <?= number_format($hairstyle['price'], 0, ',', '.') ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <input type="hidden" name="hairstyle_id" id="hairstyle_id" value="<?= $selected_hairstyle ? $selected_hairstyle['id'] : '' ?>" required>
        </div>

        <!-- Booking Details -->
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6">
            <h2 class="text-lg md:text-xl font-semibold mb-4">Detail Booking</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div>
                    <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Booking *
                    </label>
                    <input type="date" id="booking_date" name="booking_date" required
                           min="<?= date('Y-m-d') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-accent focus:border-accent">
                </div>
                
                <div>
                    <label for="booking_time" class="block text-sm font-medium text-gray-700 mb-2">
                        Waktu Booking *
                    </label>
                    <select id="booking_time" name="booking_time" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-accent focus:border-accent">
                        <option value="">Pilih waktu</option>
                        <option value="08:00">08:00</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Service Type -->
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6">
            <h2 class="text-lg md:text-xl font-semibold mb-4">Tipe Layanan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border-2 rounded-lg p-4 cursor-pointer hover:border-accent transition-colors service-option border-accent bg-yellow-50" data-type="salon">
                    <div class="flex items-center">
                        <input type="radio" name="service_type" value="salon" checked class="mr-3">
                        <div>
                            <h3 class="font-semibold text-gray-800">Salon</h3>
                            <p class="text-sm text-gray-600">Datang ke tempat kami</p>
                            <p class="text-sm text-gray-500">Biaya tambahan: Rp 0</p>
                        </div>
                    </div>
                </div>
                
                <div class="border-2 rounded-lg p-4 cursor-pointer hover:border-accent transition-colors service-option border-gray-200" data-type="home">
                    <div class="flex items-center">
                        <input type="radio" name="service_type" value="home" class="mr-3">
                        <div>
                            <h3 class="font-semibold text-gray-800">Home Service</h3>
                            <p class="text-sm text-gray-600">Kami datang ke rumah Anda</p>
                            <p class="text-sm text-gray-500">Biaya tambahan: Rp 25.000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address for Home Service -->
        <div id="address-section" class="bg-white rounded-lg shadow-lg p-6 hidden">
            <h2 class="text-xl font-semibold mb-4">Alamat Home Service</h2>
            
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat Lengkap *
                </label>
                <textarea id="address" name="address" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-accent focus:border-accent"
                          placeholder="Masukkan alamat lengkap untuk home service"></textarea>
            </div>
        </div>

        <!-- Notes -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Catatan Tambahan</h2>
            
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan (Opsional)
                </label>
                <textarea id="notes" name="notes" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-accent focus:border-accent"
                          placeholder="Tambahkan catatan khusus atau permintaan"></textarea>
            </div>
        </div>

        <!-- Price Summary -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Ringkasan Harga</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Harga Hairstyle:</span>
                    <span id="hairstyle-price">Rp 0</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Biaya Home Service:</span>
                    <span id="home-service-fee">Rp 0</span>
                </div>
                <hr class="border-gray-200">
                <div class="flex justify-between font-semibold text-lg">
                    <span>Total:</span>
                    <span id="total-price" class="text-accent">Rp 0</span>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="bg-accent text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-yellow-600 transition duration-300">
                <i class="fas fa-calendar-check mr-2"></i>
                Buat Booking
            </button>
        </div>
    </form>
</div>

<script>
// Hairstyle selection
document.querySelectorAll('.hairstyle-option').forEach(option => {
    option.addEventListener('click', function() {
        // Remove active class from all options
        document.querySelectorAll('.hairstyle-option').forEach(opt => {
            opt.classList.remove('border-accent', 'bg-yellow-50');
            opt.classList.add('border-gray-200');
        });
        
        // Add active class to selected option
        this.classList.remove('border-gray-200');
        this.classList.add('border-accent', 'bg-yellow-50');
        
        // Update hidden input
        document.getElementById('hairstyle_id').value = this.dataset.id;
        
        // Update price
        updatePrice();
    });
});

// Service type selection
document.querySelectorAll('.service-option').forEach(option => {
    option.addEventListener('click', function() {
        // Remove active class from all options
        document.querySelectorAll('.service-option').forEach(opt => {
            opt.classList.remove('border-accent', 'bg-yellow-50');
            opt.classList.add('border-gray-200');
        });
        
        // Add active class to selected option
        this.classList.remove('border-gray-200');
        this.classList.add('border-accent', 'bg-yellow-50');
        
        // Update radio button
        const radio = this.querySelector('input[type="radio"]');
        radio.checked = true;
        
        // Show/hide address section
        const serviceType = this.dataset.type;
        const addressSection = document.getElementById('address-section');
        const addressInput = document.getElementById('address');
        
        if (serviceType === 'home') {
            addressSection.classList.remove('hidden');
            addressInput.required = true;
        } else {
            addressSection.classList.add('hidden');
            addressInput.required = false;
        }
        
        // Update price
        updatePrice();
    });
});

function updatePrice() {
    const selectedHairstyle = document.querySelector('.hairstyle-option.border-accent');
    const selectedService = document.querySelector('input[name="service_type"]:checked');
    
    let hairstylePrice = 0;
    let homeServiceFee = 0;
    
    if (selectedHairstyle) {
        hairstylePrice = parseInt(selectedHairstyle.dataset.price);
    }
    
    if (selectedService && selectedService.value === 'home') {
        homeServiceFee = 25000;
    }
    
    const total = hairstylePrice + homeServiceFee;
    
    document.getElementById('hairstyle-price').textContent = `Rp ${hairstylePrice.toLocaleString('id-ID')}`;
    document.getElementById('home-service-fee').textContent = `Rp ${homeServiceFee.toLocaleString('id-ID')}`;
    document.getElementById('total-price').textContent = `Rp ${total.toLocaleString('id-ID')}`;
}

// Initialize price on page load
updatePrice();
</script>

<?= $this->endSection() ?>