<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-100">
    

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-3xl font-bold text-primary mb-4">Kedai Caruban</h2>
                    <p class="text-gray-700 mb-4">
                        Kedai Caruban adalah tempat makan yang menyajikan berbagai hidangan lezat dengan kualitas terbaik. 
                        Kami berkomitmen untuk memberikan pengalaman kuliner yang tak terlupakan bagi setiap pelanggan.
                    </p>
                    <p class="text-gray-700 mb-4">
                        Didirikan dengan semangat untuk menghadirkan cita rasa otentik, Kedai Caruban telah menjadi 
                        pilihan favorit bagi pecinta kuliner di daerah ini.
                    </p>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Visi Kami</h3>
                    <p class="text-gray-700 mb-6">
                        Menjadi destinasi kuliner terbaik yang menghadirkan kebahagiaan melalui hidangan berkualitas 
                        dengan pelayanan yang ramah dan profesional.
                    </p>
                    
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Misi Kami</h3>
                    <ul class="text-gray-700 space-y-2">
                        <li class="flex items-start">
                            <span class="text-primary mr-2">✓</span>
                            Menyajikan hidangan dengan bahan-bahan segar dan berkualitas
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">✓</span>
                            Memberikan pelayanan yang ramah dan profesional
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">✓</span>
                            Menciptakan suasana yang nyaman dan menyenangkan
                        </li>
                        <li class="flex items-start">
                            <span class="text-primary mr-2">✓</span>
                            Terus berinovasi dalam menu dan pelayanan
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Lokasi Kedai Caruban -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Lokasi Kedai Caruban</h3>
                
                <!-- Leaflet Map -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
                
                <div id="map" class="rounded-lg overflow-hidden shadow-lg" style="height: 450px; width: 100%;"></div>
                
                <script>
                    // Inisialisasi map
                    const map = L.map('map').setView([-7.800851, 110.398633], 16);
                    
                    // Add tile layer
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors',
                        maxZoom: 19
                    }).addTo(map);
                    
                    // Add marker dengan popup
                    const marker = L.marker([-7.800851, 110.398633]).addTo(map);
                    marker.bindPopup('<div class="text-center"><strong>📍 Kedai Caruban</strong><br><small>Kedai Caruban, Indonesia</small></div>').openPopup();
                    
                    // Custom marker icon
                    const customIcon = L.icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });
                    
                    marker.setIcon(customIcon);
                </script>
                
                <div class="mt-6 bg-green-50 p-6 rounded-lg">
                    <p class="text-gray-700 mb-3">
                        <span class="font-semibold text-gray-800">📍 Alamat:</span><br>
                        Kedai Caruban, Indonesia
                    </p>
                    <p class="text-gray-600 mb-4">
                        Klik link di bawah untuk navigasi langsung atau petunjuk arah:
                    </p>
                    <a href="https://maps.app.goo.gl/QHCCbRk5rHUdpKMN6" target="_blank" rel="noopener noreferrer" class="inline-block bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-light transition font-semibold">
                        📍 Buka di Google Maps
                    </a>
                </div>
            </div>

            <div class="mt-12 grid md:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-green-50 rounded-lg">
                    <div class="text-4xl font-bold text-primary mb-2">10+</div>
                    <div class="text-gray-700">Tahun Pengalaman</div>
                </div>
                <div class="text-center p-6 bg-green-50 rounded-lg">
                    <div class="text-4xl font-bold text-primary mb-2">50+</div>
                    <div class="text-gray-700">Menu Pilihan</div>
                </div>
                <div class="text-center p-6 bg-green-50 rounded-lg">
                    <div class="text-4xl font-bold text-primary mb-2">1000+</div>
                    <div class="text-gray-700">Pelanggan Puas</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/frontend/company.blade.php ENDPATH**/ ?>