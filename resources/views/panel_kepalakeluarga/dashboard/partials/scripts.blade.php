<script>
    const memberData = @json($memberDataJs);
    const checkupHistory = @json($checkupHistoryJs);
    let currentChart = null;
    let currentFilterMember = 'all';
    let memberCharts = {};
    const activeSectionKey = 'kepala-keluarga-dashboard-active-section';

    function getInitialSection() {
        const url = new URL(window.location.href);
        const urlSection = url.searchParams.get('section');
        if (urlSection && document.getElementById(urlSection)) {
            return urlSection;
        }

        const savedSection = localStorage.getItem(activeSectionKey);
        if (savedSection && document.getElementById(savedSection)) {
            return savedSection;
        }

        return 'dashboard';
    }

    function syncSectionToUrl(sectionName) {
        const url = new URL(window.location.href);
        url.searchParams.set('section', sectionName);
        window.history.replaceState({}, '', url);
    }

    function updateActiveSectionButton(sectionName, triggerButton = null) {
        document.querySelectorAll('.nav-btn').forEach(btn => { btn.classList.remove('active'); btn.style.backgroundColor = 'transparent'; btn.style.boxShadow = 'none'; });
        const activeButton = triggerButton || Array.from(document.querySelectorAll('.nav-btn')).find(btn => btn.getAttribute('onclick') && btn.getAttribute('onclick').includes(`showSection('${sectionName}'`));
        if (activeButton) {
            activeButton.classList.add('active');
        }
    }

    function showSection(sectionName, triggerButton = null) {
        document.querySelectorAll('.section').forEach(section => section.classList.add('hidden'));
        document.getElementById(sectionName).classList.remove('hidden');
        updateActiveSectionButton(sectionName, triggerButton);
        const titles = { dashboard: 'Dashboard', 'anggota-keluarga': 'Anggota Keluarga', 'riwayat-pemeriksaan': 'Riwayat Pemeriksaan Keluarga', profile: 'Profile Saya' };
        document.getElementById('page-title').textContent = titles[sectionName];
        localStorage.setItem(activeSectionKey, sectionName);
        syncSectionToUrl(sectionName);
        if (sectionName === 'riwayat-pemeriksaan') renderCheckupHistory('all');
    }

    function showMemberDetail(memberName) {
        const data = memberData[memberName];
        if (!data) return;
        document.getElementById('modal-title').textContent = `Detail ${memberName}`;
        document.getElementById('member-name').textContent = data.name;
        document.getElementById('member-nik').textContent = data.nik;
        document.getElementById('member-dob').textContent = data.dob;
        document.getElementById('member-age').textContent = data.age;
        document.getElementById('member-gender').textContent = data.gender;
        document.getElementById('member-relation').textContent = data.relation;
        document.getElementById('member-bp').textContent = data.bp;
        document.getElementById('member-weight').textContent = data.weight;
        document.getElementById('member-height').textContent = data.height;
        document.getElementById('member-cholesterol').textContent = data.cholesterol;
        document.getElementById('member-glucose').textContent = data.glucose;
        document.getElementById('member-checkup-date').textContent = data.checkupDate;
        const checkupTable = document.getElementById('member-checkup-table');
        const memberCheckups = (checkupHistory[memberName] || []).flatMap(monthData => monthData.checkups || []);
        checkupTable.innerHTML = memberCheckups.length ? memberCheckups.slice(0, 10).map(checkup => `<tr><td class="px-4 py-3 text-gray-700">${checkup.date}</td><td class="px-4 py-3 text-gray-700">Pemeriksaan Kesehatan</td><td class="px-4 py-3"><span class="${checkup.status === 'Sehat' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'} px-2 py-1 rounded text-xs">${checkup.status}</span></td><td class="px-4 py-3 text-gray-600">TD: ${checkup.bp}, BB: ${checkup.weight}, GDS: ${checkup.glucose}</td></tr>`).join('') : '<tr><td colspan="4" class="px-4 py-3 text-gray-500 text-center">Belum ada data pemeriksaan.</td></tr>';
        document.getElementById('member-detail-modal').classList.remove('hidden');
        document.getElementById('member-detail-modal').classList.add('flex');
        setTimeout(() => createWeightChart(data.weightHistory, data.dateLabels), 100);
    }

    function closeMemberDetail() {
        document.getElementById('member-detail-modal').classList.add('hidden');
        document.getElementById('member-detail-modal').classList.remove('flex');
        if (currentChart) currentChart.destroy();
    }

    function createWeightChart(data, labels) {
        if (currentChart) currentChart.destroy();
        const ctx = document.getElementById('weight-chart').getContext('2d');
        currentChart = new Chart(ctx, { type: 'line', data: { labels, datasets: [{ label: 'Berat Badan (kg)', data, borderColor: '#3B82F6', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 2, tension: 0.4, fill: true, pointRadius: 4, pointBackgroundColor: '#3B82F6', pointBorderColor: '#fff', pointBorderWidth: 2 }] }, options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: true, labels: { usePointStyle: true, padding: 20, font: { size: 12 } } } }, scales: { y: { beginAtZero: false, grid: { color: 'rgba(0, 0, 0, 0.05)' } }, x: { grid: { display: false } } } } });
    }

    function createCheckupChart(memberName, monthData, canvasElement) {
        if (memberCharts[memberName]) memberCharts[memberName].destroy();
        const ctx = canvasElement.getContext('2d');
        memberCharts[memberName] = new Chart(ctx, { type: 'line', data: { labels: monthData.historicalDates, datasets: [{ label: 'Berat Badan (kg)', data: monthData.historicalWeights, borderColor: '#10B981', backgroundColor: 'rgba(16, 185, 129, 0.1)', borderWidth: 2, tension: 0.4, fill: true, pointRadius: 3, pointBackgroundColor: '#10B981', pointBorderColor: '#fff', pointBorderWidth: 1 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: true, labels: { usePointStyle: true, padding: 15, font: { size: 12 } } } }, scales: { y: { beginAtZero: false, grid: { color: 'rgba(0, 0, 0, 0.05)' } }, x: { grid: { display: false } } } } });
    }

    function togglePasswordVisibility(fieldId) { const passwordField = document.getElementById(fieldId); const iconField = document.getElementById(`icon-${fieldId}`); if (passwordField.type === 'password') { passwordField.type = 'text'; iconField.classList.remove('fa-eye'); iconField.classList.add('fa-eye-slash'); } else { passwordField.type = 'password'; iconField.classList.remove('fa-eye-slash'); iconField.classList.add('fa-eye'); } }
    function resetPasswordForm() { document.getElementById('oldPassword').value = ''; document.getElementById('newPassword').value = ''; document.getElementById('confirmPassword').value = ''; document.getElementById('icon-oldPassword').classList.remove('fa-eye-slash'); document.getElementById('icon-oldPassword').classList.add('fa-eye'); document.getElementById('icon-newPassword').classList.remove('fa-eye-slash'); document.getElementById('icon-newPassword').classList.add('fa-eye'); document.getElementById('icon-confirmPassword').classList.remove('fa-eye-slash'); document.getElementById('icon-confirmPassword').classList.add('fa-eye'); document.getElementById('oldPassword').type = 'password'; document.getElementById('newPassword').type = 'password'; document.getElementById('confirmPassword').type = 'password'; }
    function switchTab(tabName) { 
        if (tabName === 'data-diri') {
            document.getElementById('form-data-diri').classList.remove('hidden');
            document.getElementById('form-password').classList.add('hidden');
        } else if (tabName === 'password') {
            document.getElementById('form-password').classList.remove('hidden');
            document.getElementById('form-data-diri').classList.add('hidden');
        }
        document.querySelectorAll('.tab-btn').forEach(btn => { 
            btn.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600'); 
            btn.classList.add('text-gray-600', 'hover:text-gray-800'); 
        }); 
        document.getElementById(`tab-${tabName}`).classList.add('border-b-2', 'border-blue-500', 'text-blue-600'); 
        document.getElementById(`tab-${tabName}`).classList.remove('text-gray-600', 'hover:text-gray-800'); 
    }
    function filterCheckupByMember(memberName, triggerButton) { currentFilterMember = memberName; document.querySelectorAll('.member-tab-btn').forEach(btn => { btn.classList.remove('bg-blue-100', 'text-blue-700'); btn.classList.add('bg-gray-100', 'text-gray-700'); }); if (triggerButton) { triggerButton.classList.remove('bg-gray-100', 'text-gray-700'); triggerButton.classList.add('bg-blue-100', 'text-blue-700'); } renderCheckupHistory(memberName); }
    function renderCheckupHistory(filter) { const container = document.getElementById('checkup-history-container'); container.innerHTML = ''; let membersToDisplay = []; if (filter === 'all') membersToDisplay = Object.keys(memberData); else membersToDisplay = [filter]; let renderedCards = 0; membersToDisplay.forEach(memberName => { const history = checkupHistory[memberName]; if (!history || !history.length) return; const memberInfo = memberData[memberName]; const card = document.createElement('div'); card.className = 'bg-white rounded-lg shadow overflow-hidden'; card.innerHTML = `<div class="p-6"><div class="flex items-center gap-4 mb-6"><img src="https://ui-avatars.com/api/?name=${memberName}&background=a6599e&color=fff&size=80" alt="${memberName}" class="w-16 h-16 rounded-full"><div><h4 class="text-lg font-bold text-gray-800">${memberName}</h4><p class="text-sm text-gray-600">${memberInfo.relation} | ${memberInfo.age}</p><p class="text-xs text-gray-500">NIK: ${memberInfo.nik}</p></div></div><div class="border-b border-gray-200 mb-4"><div class="flex gap-2 overflow-x-auto">${history.map((monthData, index) => `<button class="month-tab px-4 py-2 text-sm font-medium whitespace-nowrap ${index === 0 ? 'border-b-2 text-blue-600' : 'text-gray-600 hover:text-gray-800'}" style="${index === 0 ? 'border-color: #3B82F6;' : ''}" onclick="switchMonthTab(this, '${memberName}', ${index})">${monthData.month}</button>`).join('')}</div></div><div class="space-y-4 mb-6">${history[0].checkups.map(checkup => `<div class="bg-gray-50 p-4 rounded-lg"><div class="flex justify-between items-start mb-3"><div><p class="font-medium text-gray-800">${checkup.date}</p><span class="text-xs px-2 py-1 rounded ${checkup.status === 'Sehat' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}">${checkup.status}</span></div></div><div class="grid grid-cols-2 md:grid-cols-5 gap-3 text-sm"><div><p class="text-gray-600 text-xs">Berat Badan</p><p class="font-semibold text-gray-800">${checkup.weight}</p></div><div><p class="text-gray-600 text-xs">Tekanan Darah</p><p class="font-semibold text-gray-800">${checkup.bp}</p></div><div><p class="text-gray-600 text-xs">Kolesterol</p><p class="font-semibold text-gray-800">${checkup.cholesterol}</p></div><div><p class="text-gray-600 text-xs">Gula Darah</p><p class="font-semibold text-gray-800">${checkup.glucose}</p></div></div></div>`).join('')}</div><div class="bg-gray-50 p-4 rounded-lg"><p class="font-medium text-gray-800 mb-3">Perkembangan Berat Badan</p><div style="height: 220px; position: relative;"><canvas id="chart-${memberName.replace(/\s/g, '-')}"></canvas></div></div></div>`; container.appendChild(card); renderedCards += 1; setTimeout(() => { const chartId = `chart-${memberName.replace(/\s/g, '-')}`; const chartElement = document.getElementById(chartId); if (chartElement) createCheckupChart(memberName, history[0], chartElement); }, 100); }); if (renderedCards === 0) { container.innerHTML = `<div class="bg-white rounded-lg shadow p-8 text-center"><i class="fas fa-clipboard-list text-4xl text-gray-300 mb-3"></i><h4 class="text-lg font-semibold text-gray-800 mb-2">Data periksa belum ada</h4><p class="text-sm text-gray-500">Anggota yang dipilih belum pernah diperiksa. Riwayat akan tampil di sini setelah ada data pemeriksaan.</p></div>`; } }
    function switchMonthTab(button, memberName, monthIndex) { const history = checkupHistory[memberName]; const monthData = history[monthIndex]; const card = button.closest('.bg-white'); card.querySelectorAll('.month-tab').forEach(btn => { btn.classList.remove('border-b-2', 'text-blue-600'); btn.classList.add('text-gray-600'); btn.style.borderColor = 'transparent'; }); button.classList.add('border-b-2', 'text-blue-600'); button.style.borderColor = '#3B82F6'; const checkupContainer = card.querySelector('[class*="space-y-4"]'); checkupContainer.innerHTML = monthData.checkups.map(checkup => `<div class="bg-gray-50 p-4 rounded-lg"><div class="flex justify-between items-start mb-3"><div><p class="font-medium text-gray-800">${checkup.date}</p><span class="text-xs px-2 py-1 rounded ${checkup.status === 'Sehat' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}">${checkup.status}</span></div></div><div class="grid grid-cols-2 md:grid-cols-5 gap-3 text-sm"><div><p class="text-gray-600 text-xs">Berat Badan</p><p class="font-semibold text-gray-800">${checkup.weight}</p></div><div><p class="text-gray-600 text-xs">Tekanan Darah</p><p class="font-semibold text-gray-800">${checkup.bp}</p></div><div><p class="text-gray-600 text-xs">Kolesterol</p><p class="font-semibold text-gray-800">${checkup.cholesterol}</p></div><div><p class="text-gray-600 text-xs">Gula Darah</p><p class="font-semibold text-gray-800">${checkup.glucose}</p></div></div></div>`).join(''); const chartId = `chart-${memberName.replace(/\s/g, '-')}`; const chartElement = card.querySelector(`#${chartId}`); if (chartElement) createCheckupChart(memberName, monthData, chartElement); }
    const newsData = { @if(!empty($news['aktif']) && !empty($news['judul'])) 1: { title: @json($news['judul']), date: @json(now()->translatedFormat('d M Y')), category: 'Info', badge: 'bg-blue-500', image: @json($news['gambar'] ? asset($news['gambar']) : 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=600&h=400&fit=crop'), content: @json(strip_tags($news['isi'])), photos: [] } @endif };
    function showNewsDetail(newsId) { const news = newsData[newsId]; if (!news) return; document.getElementById('news-title').textContent = news.title; document.getElementById('news-date').textContent = news.date; document.getElementById('news-image').src = news.image; document.getElementById('news-badge').textContent = news.category; document.getElementById('news-badge').className = `absolute top-4 left-4 text-xs px-3 py-1 rounded text-white ${news.badge}`; document.getElementById('news-content').textContent = news.content; if (news.photos && news.photos.length > 0) { document.getElementById('photos-section').style.display = 'block'; const photosContainer = document.getElementById('news-photos'); photosContainer.innerHTML = ''; news.photos.forEach(photo => { const img = document.createElement('img'); img.src = photo; img.alt = 'Galeri Kegiatan'; img.className = 'w-full h-32 object-cover rounded cursor-pointer hover:opacity-80 transition'; img.onclick = () => window.open(photo, '_blank'); photosContainer.appendChild(img); }); } else { document.getElementById('photos-section').style.display = 'none'; } if (news.eventTime || news.eventLocation || news.eventContact) { document.getElementById('event-details-section').style.display = 'block'; if (news.eventTime) { document.getElementById('event-time').style.display = 'block'; document.getElementById('event-time-text').textContent = news.eventTime; } else document.getElementById('event-time').style.display = 'none'; if (news.eventLocation) { document.getElementById('event-location').style.display = 'block'; document.getElementById('event-location-text').textContent = news.eventLocation; } else document.getElementById('event-location').style.display = 'none'; if (news.eventContact) { document.getElementById('event-contact').style.display = 'block'; document.getElementById('event-contact-text').textContent = news.eventContact; } else document.getElementById('event-contact').style.display = 'none'; } else document.getElementById('event-details-section').style.display = 'none'; document.getElementById('news-detail-modal').classList.remove('hidden'); document.getElementById('news-detail-modal').classList.add('flex'); }
    function closeNewsDetail() { document.getElementById('news-detail-modal').classList.add('hidden'); document.getElementById('news-detail-modal').classList.remove('flex'); }
    document.addEventListener('DOMContentLoaded', function() { const modal = document.getElementById('news-detail-modal'); if (modal) { modal.addEventListener('click', function(event) { if (event.target === this) closeNewsDetail(); }); } });
    document.addEventListener('DOMContentLoaded', function() {
        const savedSection = getInitialSection();
        if (document.getElementById(savedSection)) {
            showSection(savedSection);
        }
    });
</script>
